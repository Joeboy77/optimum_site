# 🚀 OES System Deployment Checklist

## ✅ Completed Steps
- [x] Database created on InfinityFree
- [x] Database imported successfully (26 queries executed)
- [x] Admin user created (admin/admin123)
- [x] config.php updated with production credentials

## 📋 Next Steps

### 1. Upload Application Files
- [ ] Login to InfinityFree File Manager
- [ ] Navigate to `public_html` folder
- [ ] Upload entire `optimumsite` folder contents
- [ ] Ensure all files are in `public_html` root

### 2. Set File Permissions
- [ ] Set folders to 755
- [ ] Set PHP files to 644
- [ ] Set upload folders to 777 (images/, files/, etc.)

### 3. Test Application
- [ ] Visit your website URL
- [ ] Test admin login (admin/admin123)
- [ ] Verify database connection
- [ ] Test student registration
- [ ] Test exam creation
- [ ] Test file uploads

### 4. Security & Optimization
- [ ] Remove debug files (export-database.php, etc.)
- [ ] Set proper error reporting for production
- [ ] Test all user roles (Admin, Tutor, Student)

## 🔗 Important URLs
- **Main Site:** `https://yourdomain.infinityfreeapp.com`
- **Admin Panel:** `https://yourdomain.infinityfreeapp.com/oes/admin/`
- **Student Portal:** `https://yourdomain.infinityfreeapp.com/oes/student/`
- **Tutor Portal:** `https://yourdomain.infinityfreeapp.com/oes/staff/`

## 🆘 Troubleshooting
- **Database Connection Issues:** Check config.php credentials
- **File Upload Issues:** Check folder permissions (777)
- **Login Issues:** Verify admin user exists in registration table
- **404 Errors:** Check file paths and .htaccess

## 📞 Support
## 🐳 Run with Docker (Local Anywhere)

### Prerequisites
- Install Docker Desktop

### Start the stack
    docker compose up -d --build

### Services
- App: http://localhost:8080
- phpMyAdmin: http://localhost:8081 (server: db, user: oes_user, pass: oes_pass)

### Database
- Host: db
- Name: optimumsite
- User: oes_user
- Pass: oes_pass

### Import the clean SQL
1. Open phpMyAdmin at http://localhost:8081
2. Select `optimumsite` database
3. Import your clean SQL file (e.g., `oes_database_CLEAN_*.sql`)

### Logs
    docker compose logs -f web
    docker compose logs -f db

### Stop
    docker compose down
- InfinityFree Support: https://infinityfree.net/support/
- phpMyAdmin: Available in control panel
- File Manager: Available in control panel