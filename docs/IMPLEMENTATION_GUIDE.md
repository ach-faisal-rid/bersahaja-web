# API Mobile Implementation Guide

Panduan lengkap untuk setup dan menjalankan API Mobile di development dan production.

## Quick Start

### 1. Setup Awal (Development)

Aplikasi semua sudah siap, tinggal follow langkah ini:

#### Pastikan Database Sudah Disetup
```bash
# Run migrations
php artisan migrate

# Seed data (optional, jika ada)
php artisan db:seed
```

#### Pastikan User Model Valid
```bash
# User model sudah include HasApiTokens trait ✅
```

#### Cek Routes API
```bash
# List semua routes
php artisan route:list --path=api

# Output akan menampilkan semua /api/v1/* routes
```

---

## Testing API

### Using Postman

1. **Import Collection**
   - Buat collection baru bernama "Bersahaja Mobile API"
   - Copy endpoints dari `API_DOCUMENTATION.md`

2. **Setup Environment**
   - Base URL: `http://localhost:8000/api/v1` (development)
   - Atau `https://your-domain.com/api/v1` (production)

3. **Setup Auth Token**
   - Setelah login, copy token dari response
   - Di Postman: Tabs → Select all → Authorization → Type: Bearer Token → Paste token

### Using cURL

```bash
# 1. Register
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# 2. Login (dapatkan token)
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'

# 3. Gunakan token untuk protected routes
curl -X GET http://localhost:8000/api/v1/user/profile \
  -H "Authorization: Bearer {TOKEN_DARI_LOGIN}"
```

### Using Artisan Tinker

```bash
php artisan tinker

# Create test user
$user = User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => Hash::make('password123')
]);

# Create token
$token = $user->createToken('mobile-app')->plainTextToken;

echo $token; // Copy ini dan gunakan di API requests
```

---

## API Endpoints Summary

### Public Endpoints (Tidak butuh token)
- ✅ `POST /auth/register` - Register user baru
- ✅ `POST /auth/login` - Login
- ✅ `POST /auth/forgot-password` - Request password reset
- ✅ `GET /doas` - List doas
- ✅ `GET /doas/{id}` - Detail doa
- ✅ `GET /hadists` - List hadists
- ✅ `GET /hadists/{id}` - Detail hadist
- ✅ `GET /tata-cara` - List tata cara
- ✅ `GET /tata-cara/{id}` - Detail tata cara
- ✅ `GET /gerakan-shalat` - List gerakan shalat
- ✅ `GET /gerakan-shalat/{id}` - Detail gerakan
- ✅ `GET /bacaan` - List bacaan
- ✅ `GET /bacaan/{id}` - Detail bacaan
- ✅ `GET /wudu` - List wudu
- ✅ `GET /wudu/{id}` - Detail wudu
- ✅ `GET /hijri/events` - Hijri events
- ✅ `GET /hijri/calendar` - Hijri calendar

### Protected Endpoints (Butuh token)
- ✅ `GET /auth/me` - Get current user info
- ✅ `POST /auth/logout` - Logout
- ✅ `POST /auth/refresh` - Refresh token
- ✅ `GET /user/profile` - Get user profile
- ✅ `PUT /user/profile` - Update profile
- ✅ `DELETE /user/profile` - Delete account
- ✅ `GET /favorit` - List favorits
- ✅ `POST /favorit` - Add to favorit
- ✅ `DELETE /favorit/{id}` - Remove from favorit
- ✅ `GET /hijri/pinned-days` - List pinned days
- ✅ `POST /hijri/pinned-days` - Add pinned day
- ✅ `DELETE /hijri/pinned-days/{id}` - Delete pinned day

---

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── V1/
│   │           ├── Auth/
│   │           │   └── AuthController.php
│   │           ├── DoaController.php
│   │           ├── HadistController.php
│   │           ├── TataCaraController.php
│   │           ├── GerakanShalatController.php
│   │           ├── BacaanController.php
│   │           ├── WuduController.php
│   │           ├── HijriEventController.php
│   │           ├── FavoritController.php
│   │           ├── UserController.php
│   │           └── PinnedDayController.php
│   └── Traits/
│       └── ApiResponseTrait.php
├── Models/
│   ├── User.php (with HasApiTokens)
│   └── ... (other models)
└── Providers/
    └── ...

routes/
├── api/
│   └── mobile.php (API routes with /api/v1 prefix)
├── web.php (Web routes)
└── ...
```

---

## Development Workflow

### 1. Menjalankan Server

```bash
# Terminal 1: Start Laravel server
php artisan serve

# Server running di http://localhost:8000
```

### 2. Testing Endpoints

**Option A: Menggunakan Postman**
- Import collection dari dokumentasi
- Langsung test endpoints

**Option B: Menggunakan Artisan CLI**
```bash
# Test protected route dengan Tinker
php artisan tinker

# Get atau create user
$user = User::first();

# Buat token
$token = $user->createToken('mobile-app')->plainTextToken;

# Test dengan curl
exit # keluar dari tinker
```

Kemudian test dengan curl di terminal terpisah.

### 3. API Response Examples

**Success Response (200/201):**
```json
{
    "success": true,
    "message": "Success message",
    "data": {...}
}
```

**Paginated Response:**
```json
{
    "success": true,
    "message": "Success message",
    "data": [...],
    "pagination": {
        "total": 100,
        "count": 15,
        "per_page": 15,
        "current_page": 1,
        "total_pages": 7,
        "has_more": true
    }
}
```

**Error Response:**
```json
{
    "success": false,
    "message": "Error message",
    "errors": {...} // jika ada validation error
}
```

---

## Production Deployment

### 1. Environment Setup

```bash
# Copy .env example
cp .env.example .env

# Generate app key
php artisan key:generate

# Setup database
php artisan migrate --force
```

### 2. Sanctum Configuration

Sanctum sudah ter-config default. Cek file konfigurasi:
```
config/sanctum.php
```

Key settings untuk production:
```php
'expiration' => null, // Token tidak expire
'hash' => 'sha256', // Hash algorithm
```

### 3. API Rate Limiting (Optional)

Untuk rate limiting, tambahkan di route:

```php
Route::middleware('throttle:60,1')->group(function () {
    // Protected routes
});
```

Artinya: max 60 requests per 1 menit per user.

### 4. CORS Configuration (Jika Dibutuhkan)

Jika mobile app dan API di domain berbeda, setup CORS:

```bash
# Sansum sudah handle CORS, tapi jika perlu custom:
# Edit config/cors.php
```

### 5. Monitoring & Logging

Setup logging untuk API requests (optional):

```bash
# Check logs
tail -f storage/logs/laravel.log
```

---

## Future Enhancements

### Endpoint yang bisa ditambahkan:

1. **Admin Endpoints** (Protected dengan role:admin)
   - CRUD operations untuk doas, hadists, dll
   - User management
   - Analytics/Statistics

2. **Search & Filter Enhancement**
   - Advanced filtering
   - Full-text search
   - Sorting options

3. **Notification System**
   - Push notifications untuk reminders
   - Notification preferences

4. **Social Features**
   - Share doas/hadists
   - Comments/Reviews
   - Ratings

5. **Performance**
   - Caching strategy
   - API versioning
   - Webhooks support

---

## Troubleshooting

### Error: "Unauthenticated"
**Cause:** Token tidak dikirim atau expired
**Solution:** 
- Pastikan header `Authorization: Bearer {token}` dikirim
- Login ulang untuk dapatkan token baru

### Error: "Validation failed"
**Cause:** Request body tidak valid
**Solution:**
- Cek dokumentasi untuk required fields
- Pastikan data type sesuai

### Error: "Resource not found"
**Cause:** ID resource tidak ada
**Solution:**
- Verify ID yang dikirim
- Cek database

### Error: 500 Internal Server Error
**Cause:** Server error
**Solution:**
- Check logs: `tail -f storage/logs/laravel.log`
- Debug di tinker: `php artisan tinker`

---

## Security Best Practices

1. ✅ **Authentication**: Gunakan Sanctum tokens
2. ✅ **Authorization**: Cek user ownership sebelum delete/update
3. ✅ **Validation**: Validate semua input
4. ✅ **Rate Limiting**: Implementasikan throttle untuk endpoints sensitive
5. ✅ **HTTPS**: Always gunakan HTTPS di production
6. ✅ **CORS**: Restrict origins jika perlu

---

## Contact & Support

Untuk pertanyaan atau issue, silakan hubungi tim development.
