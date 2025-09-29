# Free Hosting Deployment Guide - OES System

## Step 1: Sign Up for InfinityFree

1. Go to **infinityfree.net**
2. Click **"Sign Up"**
3. Fill in your details:
   - Email address
   - Username
   - Password
   - Confirm password
4. Verify your email
5. Login to your account

## Step 2: Create Hosting Account

1. In your dashboard, click **"Create Account"**
2. Choose **"Free Hosting"**
3. Fill in the form:
   - **Domain**: Choose a subdomain (e.g., `youroes.infinityfreeapp.com`)
   - **Password**: Create a strong password
   - **Email**: Your email address
4. Click **"Create Account"**
5. Wait for account activation (usually 5-10 minutes)

## Step 3: Access Your Control Panel

1. Go to **"Client Area"** → **"Services"** → **"My Services"**
2. Click **"Login to cPanel"** or **"Manage"**
3. You'll see your hosting control panel

## Step 4: Database Setup

1. In cPanel, find **"MySQL Databases"**
2. Create a new database:
   - Database name: `yourusername_oes_db`
   - Click **"Create Database"**
3. Create a database user:
   - Username: `yourusername_oes_user`
   - Password: Create a strong password
   - Click **"Create User"**
4. Add user to database:
   - Select user and database
   - Click **"Add"**
   - Give **"All Privileges"**
   - Click **"Make Changes"**

## Step 5: File Manager

1. In cPanel, find **"File Manager"**
2. Navigate to **"public_html"** folder
3. This is where you'll upload your files

## Step 6: Upload Your Application

### Option A: Using File Manager (Recommended for beginners)
1. In File Manager, go to **public_html**
2. Click **"Upload"**
3. Create a ZIP file of your entire project
4. Upload the ZIP file
5. Right-click the ZIP file → **"Extract"**
6. Move all files from the extracted folder to **public_html**

### Option B: Using FTP (Advanced)
1. Download an FTP client (FileZilla - free)
2. Use these credentials from cPanel:
   - **Host**: ftp.infinityfreeapp.com
   - **Username**: Your cPanel username
   - **Password**: Your cPanel password
   - **Port**: 21
3. Connect and upload files to **public_html**

## Step 7: Update Configuration

1. In File Manager, find your **config.php** file
2. Edit it with these details:
   ```php
   <?php
   $con = mysqli_connect("localhost", "your_db_username", "your_db_password") or die("Unable to connect");
   mysqli_select_db($con, "your_db_name");
   ?>
   ```
3. Replace with your actual database credentials from Step 4

## Step 8: Import Database

1. In cPanel, find **"phpMyAdmin"**
2. Click on your database name
3. Click **"Import"** tab
4. Choose your database file (.sql)
5. Click **"Go"** to import

## Step 9: Set File Permissions

1. In File Manager, select these folders:
   - `oes/uploads/`
   - `oes/student/uploads/`
   - `oes/staff/uploads/`
2. Right-click → **"Permissions"**
3. Set to **755** (rwxr-xr-x)
4. Click **"Change Permissions"**

## Step 10: Test Your Application

1. Go to your website URL: `https://youroes.infinityfreeapp.com/oes/`
2. Test all functionality:
   - User registration
   - Login (admin/admin123)
   - Exam creation
   - Quiz creation
   - File uploads

## Troubleshooting

### Common Issues:
1. **Database connection error**: Check credentials in config.php
2. **File upload not working**: Check folder permissions
3. **404 errors**: Ensure files are in public_html
4. **PHP errors**: Check error logs in cPanel

### Getting Help:
- InfinityFree Support Forum
- Check error logs in cPanel
- Test locally first

## Security Tips:
1. Change default admin password
2. Use strong database passwords
3. Keep your application updated
4. Regular backups