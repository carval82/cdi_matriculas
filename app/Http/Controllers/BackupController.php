<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BackupController extends Controller
{
    /**
     * Vista principal de backup y restauración.
     */
    public function index()
    {
        $backups = $this->listarBackups();
        return view('backup.index', compact('backups'));
    }

    /**
     * Generar backup de la base de datos.
     */
    public function backup()
    {
        $database = Config::get('database.connections.mysql.database');
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');
        $host = Config::get('database.connections.mysql.host');
        $port = Config::get('database.connections.mysql.port', 3306);

        $filename = 'backup_' . $database . '_' . date('Y-m-d_His') . '.sql';
        $backupPath = storage_path('app/backups');

        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $filePath = $backupPath . DIRECTORY_SEPARATOR . $filename;

        // Buscar mysqldump en rutas comunes de XAMPP
        $mysqldump = $this->findMysqldump();

        if (!$mysqldump) {
            return back()->with('error', 'No se encontró mysqldump. Verifica la instalación de MySQL/XAMPP.');
        }

        $passwordParam = $password ? "-p\"{$password}\"" : '';
        $command = "\"{$mysqldump}\" -h {$host} -P {$port} -u {$username} {$passwordParam} --single-transaction --routines --triggers {$database} > \"{$filePath}\" 2>&1";

        exec($command, $output, $returnCode);

        if ($returnCode !== 0 || !file_exists($filePath) || filesize($filePath) === 0) {
            // Si mysqldump falla, intentar backup manual con PHP
            $result = $this->backupManual($filePath, $database);
            if (!$result) {
                return back()->with('error', 'Error al generar el backup. Código: ' . $returnCode);
            }
        }

        return back()->with('success', "Backup creado exitosamente: {$filename} (" . $this->formatSize(filesize($filePath)) . ")");
    }

    /**
     * Descargar un backup.
     */
    public function download($filename)
    {
        $filePath = storage_path('app/backups/' . $filename);

        if (!file_exists($filePath)) {
            return back()->with('error', 'El archivo de backup no existe.');
        }

        return response()->download($filePath, $filename, [
            'Content-Type' => 'application/sql',
        ]);
    }

    /**
     * Eliminar un backup.
     */
    public function destroy($filename)
    {
        $filePath = storage_path('app/backups/' . $filename);

        if (file_exists($filePath)) {
            unlink($filePath);
            return back()->with('success', 'Backup eliminado correctamente.');
        }

        return back()->with('error', 'El archivo no existe.');
    }

    /**
     * Restaurar un backup desde archivo existente.
     */
    public function restore(Request $request)
    {
        $filename = $request->input('filename');
        $filePath = null;

        // Si se sube un archivo nuevo
        if ($request->hasFile('backup_file')) {
            $request->validate([
                'backup_file' => 'required|file|max:51200', // 50MB max
            ]);

            $file = $request->file('backup_file');
            $ext = strtolower($file->getClientOriginalExtension());

            if ($ext !== 'sql') {
                return back()->with('error', 'Solo se permiten archivos .sql');
            }

            $backupPath = storage_path('app/backups');
            if (!is_dir($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            $filename = $file->getClientOriginalName();
            $file->move($backupPath, $filename);
            $filePath = $backupPath . DIRECTORY_SEPARATOR . $filename;
        } elseif ($filename) {
            $filePath = storage_path('app/backups/' . $filename);
        }

        if (!$filePath || !file_exists($filePath)) {
            return back()->with('error', 'No se encontró el archivo de backup.');
        }

        $database = Config::get('database.connections.mysql.database');
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');
        $host = Config::get('database.connections.mysql.host');
        $port = Config::get('database.connections.mysql.port', 3306);

        $mysql = $this->findMysql();

        if (!$mysql) {
            // Restauración manual con PHP
            $result = $this->restoreManual($filePath);
            if (!$result) {
                return back()->with('error', 'No se encontró mysql y la restauración manual falló.');
            }
            return back()->with('success', 'Base de datos restaurada exitosamente desde: ' . $filename);
        }

        $passwordParam = $password ? "-p\"{$password}\"" : '';
        $command = "\"{$mysql}\" -h {$host} -P {$port} -u {$username} {$passwordParam} {$database} < \"{$filePath}\" 2>&1";

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            return back()->with('error', 'Error al restaurar el backup. ' . implode("\n", $output));
        }

        return back()->with('success', 'Base de datos restaurada exitosamente desde: ' . $filename);
    }

    // ─── Métodos auxiliares ───

    private function listarBackups(): array
    {
        $backupPath = storage_path('app/backups');
        $backups = [];

        if (!is_dir($backupPath)) {
            return $backups;
        }

        $files = scandir($backupPath);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                $fullPath = $backupPath . DIRECTORY_SEPARATOR . $file;
                $backups[] = [
                    'filename' => $file,
                    'size' => $this->formatSize(filesize($fullPath)),
                    'date' => date('d/m/Y H:i:s', filemtime($fullPath)),
                    'timestamp' => filemtime($fullPath),
                ];
            }
        }

        // Ordenar por fecha descendente
        usort($backups, fn($a, $b) => $b['timestamp'] - $a['timestamp']);

        return $backups;
    }

    private function findMysqldump(): ?string
    {
        $paths = [
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            'C:\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\mysqldump.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe',
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) return $path;
        }

        // Intentar en PATH del sistema
        $result = shell_exec('where mysqldump 2>nul') ?? shell_exec('which mysqldump 2>/dev/null');
        if ($result) return trim($result);

        return null;
    }

    private function findMysql(): ?string
    {
        $paths = [
            'C:\\xampp\\mysql\\bin\\mysql.exe',
            'C:\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\mysql.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysql.exe',
            '/usr/bin/mysql',
            '/usr/local/bin/mysql',
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) return $path;
        }

        $result = shell_exec('where mysql 2>nul') ?? shell_exec('which mysql 2>/dev/null');
        if ($result) return trim($result);

        return null;
    }

    /**
     * Backup manual usando PHP (fallback si mysqldump no está disponible).
     */
    private function backupManual(string $filePath, string $database): bool
    {
        try {
            $tables = DB::select('SHOW TABLES');
            $key = 'Tables_in_' . $database;
            $sql = "-- Backup generado por CDI Matrículas\n";
            $sql .= "-- Fecha: " . date('Y-m-d H:i:s') . "\n";
            $sql .= "-- Base de datos: {$database}\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            foreach ($tables as $table) {
                $tableName = $table->$key;

                // Estructura
                $create = DB::select("SHOW CREATE TABLE `{$tableName}`");
                $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $sql .= $create[0]->{'Create Table'} . ";\n\n";

                // Datos
                $rows = DB::select("SELECT * FROM `{$tableName}`");
                if (count($rows) > 0) {
                    $columns = array_keys((array) $rows[0]);
                    $columnList = '`' . implode('`, `', $columns) . '`';

                    foreach (array_chunk($rows, 100) as $chunk) {
                        $sql .= "INSERT INTO `{$tableName}` ({$columnList}) VALUES\n";
                        $values = [];
                        foreach ($chunk as $row) {
                            $rowValues = [];
                            foreach ((array) $row as $value) {
                                if (is_null($value)) {
                                    $rowValues[] = 'NULL';
                                } else {
                                    $rowValues[] = "'" . addslashes($value) . "'";
                                }
                            }
                            $values[] = '(' . implode(', ', $rowValues) . ')';
                        }
                        $sql .= implode(",\n", $values) . ";\n\n";
                    }
                }
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

            file_put_contents($filePath, $sql);
            return filesize($filePath) > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Restauración manual usando PHP (fallback si mysql CLI no está disponible).
     */
    private function restoreManual(string $filePath): bool
    {
        try {
            $sql = file_get_contents($filePath);

            // Eliminar comentarios
            $sql = preg_replace('/^--.*$/m', '', $sql);
            $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);

            DB::unprepared($sql);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function formatSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
