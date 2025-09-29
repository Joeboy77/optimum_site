# 🚀 Quick Free Deployment Guide

## ⚡ 5-Minute Setup (InfinityFree)

### 1. Sign Up (2 minutes)
- Go to **infinityfree.net**
- Click **"Sign Up"**
- Verify email

### 2. Create Hosting (1 minute)
- Login → **"Create Account"**
- Choose subdomain: `youroes.infinityfreeapp.com`
- Wait for activation

### 3. Prepare Files (1 minute)
- Run `prepare-for-deployment.php` locally
- Run `export-database.php` to export database
- Create ZIP of entire project

### 4. Upload (1 minute)
- Login to cPanel
- File Manager → public_html
- Upload ZIP → Extract
- Move files to public_html root

### 5. Database Setup
- cPanel → MySQL Databases
- Create database: `yourusername_oes`
- Create user: `yourusername_oes_user`
- phpMyAdmin → Import your .sql file

### 6. Update Config
Edit `config.php`:
```php
<?php
$con = mysqli_connect("localhost", "yourusername_oes_user", "your_password") or die("Unable to connect");
mysqli_select_db($con, "yourusername_oes");
?>
```

### 7. Test
Visit: `https://youroes.infinityfreeapp.com/oes/`
Login: admin / admin123

## 🎯 Your Live URL
`https://youroes.infinityfreeapp.com/oes/`

## 📞 Need Help?
- Check error logs in cPanel
- Test locally first
- InfinityFree support forum

## 🔒 Security
- Change admin password
- Use strong database passwords
- Regular backups