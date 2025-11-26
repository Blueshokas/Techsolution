@echo off
cd C:\xampp\htdocs\Techsolution\BDD
C:\xampp\mysql\bin\mysqldump -uroot techsolution>techsolution.sql
cd C:\xampp\htdocs\Techsolution
git add .
git commit -m "sauvegarde"
git push origin main
pause