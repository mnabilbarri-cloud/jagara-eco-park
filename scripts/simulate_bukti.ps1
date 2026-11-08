$kode='JG178135609639'
$ts=Get-Date -Format yyyyMMddHHmmss
$src='d:\xampp\htdocs\jagara_framework\public\assets\images\logo.jpg'
$dest="d:\xampp\htdocs\jagara_framework\public\assets\images\bukti_bayar\BUKTI_${kode}_${ts}.jpg"
if (-not (Test-Path -Path (Split-Path $dest -Parent))) {
    New-Item -ItemType Directory -Path (Split-Path $dest -Parent) | Out-Null
}
Copy-Item -Path $src -Destination $dest -Force
Write-Output $dest
