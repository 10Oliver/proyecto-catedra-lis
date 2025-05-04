# Script para combinar archivos PHP y de vistas en un solo TXT
$outputFile = "output.txt"
$basePath = ".\"  # Asume que ejecutas desde la raíz del proyecto Laravel

# Carpetas a incluir
$folders = @(
    "app\Actions",
    "app\Http\Controllers",
    "app\Http\Requests",
    "app\Http\Responses",
    "app\Models",
    "app\Providers",
    "database",
    "resources\views",
    "routes"
)

# Eliminar archivo de salida si existe
if (Test-Path $outputFile) {
    Remove-Item $outputFile
}

# Procesar cada carpeta
foreach ($folder in $folders) {
    $fullPath = Join-Path $basePath $folder
    
    if (Test-Path $fullPath) {
        # Obtener archivos PHP, blade.php y archivos de rutas
        $files = Get-ChildItem -Path $fullPath -Recurse -Include *.php, *.blade.php, web.php, api.php, console.php
        
        foreach ($file in $files) {
            $relativePath = $file.FullName.Replace((Get-Item $basePath).FullName, "").TrimStart('\')
            
            # Escribir comentario con la ruta
            Add-Content -Path $outputFile -Value "===== $relativePath ====="
            
            # Escribir contenido del archivo
            Get-Content -Path $file.FullName | Add-Content -Path $outputFile
            
            # Añadir separador
            Add-Content -Path $outputFile -Value "`r`n"
        }
    } else {
        Write-Host "Carpeta no encontrada: $fullPath"
    }
}

Write-Host "Archivo combinado creado: $outputFile"