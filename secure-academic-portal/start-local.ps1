$ErrorActionPreference = 'Stop'
$taskRuntime = Join-Path $PSScriptRoot '..\..\.runtime'
$taskPhp = Join-Path $taskRuntime 'php84\php.exe'
if (-not (Test-Path -LiteralPath $taskPhp)) {
    $taskPhp = (Get-Command php -ErrorAction Stop).Source
}

function Test-LocalPort([int] $Port) {
    $taskClient = New-Object System.Net.Sockets.TcpClient
    try {
        $taskClient.Connect('127.0.0.1', $Port)
        return $true
    } catch {
        return $false
    } finally {
        $taskClient.Dispose()
    }
}

if (-not (Test-Path -LiteralPath (Join-Path $PSScriptRoot '.env'))) {
    throw 'Siapkan .env dan database MySQL mengikuti README.md terlebih dahulu.'
}
$taskEnvironment = Get-Content -LiteralPath (Join-Path $PSScriptRoot '.env')
$taskPortLine = $taskEnvironment | Where-Object { $_ -match '^DB_PORT=' } | Select-Object -First 1
$taskDatabasePort = if ($taskPortLine) { [int] ($taskPortLine -replace '^DB_PORT=', '') } else { 3306 }
if (-not (Test-LocalPort $taskDatabasePort)) {
    $taskData = Join-Path $taskRuntime 'mysql-pbkk6\data'
    $taskMysql = Join-Path $env:ProgramFiles 'MySQL\MySQL Server 9.6\bin\mysqld.exe'
    if ($taskDatabasePort -ne 3307 -or -not (Test-Path -LiteralPath $taskData) -or -not (Test-Path -LiteralPath $taskMysql)) {
        throw "Nyalakan server MySQL pada port $taskDatabasePort sesuai .env terlebih dahulu."
    }
    $taskBase = Split-Path (Split-Path $taskMysql -Parent) -Parent
    $taskMysqlLog = Join-Path $taskRuntime 'mysql-pbkk6\mysql.log'
    Start-Process -FilePath $taskMysql -ArgumentList @(
        '--no-defaults', ('--basedir="' + $taskBase + '"'), ('--datadir="' + $taskData + '"'),
        '--port=3307', '--bind-address=127.0.0.1', '--mysqlx=OFF', ('--log-error="' + $taskMysqlLog + '"')
    ) -WindowStyle Hidden | Out-Null
    for ($taskAttempt = 0; $taskAttempt -lt 40 -and -not (Test-LocalPort $taskDatabasePort); $taskAttempt++) {
        Start-Sleep -Milliseconds 250
    }
    if (-not (Test-LocalPort $taskDatabasePort)) { throw "MySQL gagal menyala. Periksa $taskMysqlLog" }
}

if (-not (Test-LocalPort 8000)) {
    Start-Process -FilePath $taskPhp -ArgumentList @('artisan', 'serve', '--host=127.0.0.1', '--port=8000', '--no-reload') `
        -WorkingDirectory $PSScriptRoot -WindowStyle Hidden `
        -RedirectStandardOutput (Join-Path $PSScriptRoot 'storage\logs\dev-server.log') `
        -RedirectStandardError (Join-Path $PSScriptRoot 'storage\logs\dev-server-error.log') | Out-Null
    for ($taskAttempt = 0; $taskAttempt -lt 40 -and -not (Test-LocalPort 8000); $taskAttempt++) {
        Start-Sleep -Milliseconds 250
    }
}
if (-not (Test-LocalPort 8000)) { throw 'Server aplikasi gagal menyala. Periksa storage/logs/dev-server-error.log.' }
Write-Output 'Secure Academic Portal: http://localhost:8000'
