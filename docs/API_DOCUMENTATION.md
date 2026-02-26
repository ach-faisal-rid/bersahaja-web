# API Mobile Documentation

Dokumentasi lengkap untuk API Mobile Bersahaja Web Application.

**Base URL:** `https://your-domain.com/api/v1`

**Authentication:** Token Bearer (Laravel Sanctum)



## Table of Contents
1. [Authentication](#authentication)
2. [Public Endpoints](#public-endpoints)
3. [Protected Endpoints](#protected-endpoints)
4. [Response Format](#response-format)
5. [Error Handling](#error-handling)

---

## Authentication

### Register
**POST** `/auth/register`

Register akun baru.

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "token": "1|abcdefghijklmnopqrstuvwxyz..."
    }
}
```

---

### Login
**POST** `/auth/login`

Login dengan email dan password.

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "token": "1|abcdefghijklmnopqrstuvwxyz..."
    }
}
```

**Errors:**
- `401`: Invalid credentials

---

### Forgot Password
**POST** `/auth/forgot-password`

Request password reset link.

**Request Body:**
```json
{
    "email": "john@example.com"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Password reset link has been sent to your email",
    "data": null
}
```

---

## Public Endpoints

### Doas

#### Get All Doas
**GET** `/doas?per_page=15&search=doa_name`

Get daftar semua doa dengan pagination dan pencarian.

**Query Parameters:**
- `per_page` (int, optional): Items per page, default: 15
- `search` (string, optional): Cari berdasarkan nama, arab, atau translation
- `page` (int, optional): Halaman ke-, default: 1

**Response (200):**
```json
{
    "success": true,
    "message": "Doas retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Doa Pagi",
            "arab": "أَصْبَحْنَا وَأَصْبَحَ الْمُلْكُ لِلَّهِ",
            "translation": "Kami memasuki pagi dan segala kerajaan milik Allah",
            "created_at": "2026-02-20T10:00:00Z",
            "updated_at": "2026-02-20T10:00:00Z"
        }
    ],
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

#### Get Single Doa
**GET** `/doas/{id}`

Get detail doa by ID.

**Response (200):**
```json
{
    "success": true,
    "message": "Doa retrieved successfully",
    "data": {
        "id": 1,
        "name": "Doa Pagi",
        "arab": "أَصْبَحْنَا وَأَصْبَحَ الْمُلْكُ لِلَّهِ",
        "translation": "Kami memasuki pagi dan segala kerajaan milik Allah",
        "created_at": "2026-02-20T10:00:00Z",
        "updated_at": "2026-02-20T10:00:00Z"
    }
}
```

#### Get Doas by Tag
**GET** `/doas/tags/{tagId}?per_page=15`

Get doas berdasarkan tag tertentu.

**Response (200):**
```json
{
    "success": true,
    "message": "Doas by tag retrieved successfully",
    "data": [...],
    "pagination": {...}
}
```

---

### Hadists

#### Get All Hadists
**GET** `/hadists?per_page=15&search=hadist`

Get daftar semua hadist dengan pagination dan pencarian.

**Query Parameters:**
- `per_page` (int, optional): Items per page, default: 15
- `search` (string, optional): Cari berdasarkan title, content, atau translation
- `page` (int, optional): Halaman ke-

**Response (200):**
```json
{
    "success": true,
    "message": "Hadists retrieved successfully",
    "data": [
        {
            "id": 1,
            "title": "Hadist tentang Ilmu",
            "content": "Text content...",
            "translation": "Translation...",
            "source": {...},
            "created_at": "2026-02-20T10:00:00Z"
        }
    ],
    "pagination": {...}
}
```

#### Get Single Hadist
**GET** `/hadists/{id}`

Get detail hadist by ID beserta source info.

**Response (200):**
```json
{
    "success": true,
    "message": "Hadist retrieved successfully",
    "data": {
        "id": 1,
        "title": "Hadist tentang Ilmu",
        "content": "Text content...",
        "translation": "Translation...",
        "source": {
            "id": 1,
            "name": "Sahih Bukhari"
        },
        "created_at": "2026-02-20T10:00:00Z"
    }
}
```

---

### Shalat Learning

#### Tata Cara Shalat
**GET** `/tata-cara?per_page=15`  
**GET** `/tata-cara/{id}`

Get panduan tata cara shalat.

#### Gerakan Shalat
**GET** `/gerakan-shalat?per_page=15`  
**GET** `/gerakan-shalat/{id}`

Get panduan gerakan-gerakan shalat.

#### Bacaan Shalat
**GET** `/bacaan?per_page=15&search=bacaan`  
**GET** `/bacaan/{id}`

Get bacaan-bacaan dalam shalat.

#### Wudu
**GET** `/wudu?per_page=15`  
**GET** `/wudu/{id}`

Get panduan wudu.

---

### Hijri Calendar

#### Get Hijri Events
**GET** `/hijri/events?year=1445&month=10`

Get event-event hijri calendar untuk tahun dan bulan tertentu.

**Query Parameters:**
- `year` (int, optional): Tahun hijri
- `month` (int, optional): Bulan hijri (1-12)

**Response (200):**
```json
{
    "success": true,
    "message": "Hijri events retrieved successfully",
    "data": [
        {
            "id": 1,
            "title": "Ramadan",
            "hijri_date": "1445-09-01",
            "gregorian_date": "2024-03-12",
            "description": "Bulan berberkah"
        }
    ]
}
```

#### Get Hijri Calendar
**GET** `/hijri/calendar?year=1445&month=10`

Get kalender hijri lengkap untuk bulan tertentu.

**Response (200):**
```json
{
    "success": true,
    "message": "Hijri calendar retrieved successfully",
    "data": {
        "year": 1445,
        "month": 10,
        "events": [...]
    }
}
```

---

## Protected Endpoints

> **Note:** Gunakan header `Authorization: Bearer {token}` untuk semua protected endpoints

### Authentication Management

#### Get Current User
**GET** `/auth/me`

Get informasi user yang sedang login.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Success",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "email_verified_at": null
    }
}
```

#### Logout
**POST** `/auth/logout`

Logout dan hapus token saat ini.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Logout successful",
    "data": null
}
```

#### Refresh Token
**POST** `/auth/refresh`

Dapatkan token baru dengan token yang masih valid.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Token refreshed successfully",
    "data": {
        "token": "2|newtoken..."
    }
}
```

---

### User Profile

#### Get User Profile
**GET** `/user/profile`

Get profil user saat ini.

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "message": "User profile retrieved successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "email_verified_at": null,
        "created_at": "2026-02-20T10:00:00Z",
        "updated_at": "2026-02-20T10:00:00Z"
    }
}
```

#### Update User Profile
**PUT** `/user/profile`

Update nama, email, atau password.

**Request Body:**
```json
{
    "name": "John Doe Updated",
    "email": "newemail@example.com",
    "current_password": "old_password",
    "password": "new_password",
    "password_confirmation": "new_password"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Profile updated successfully",
    "data": {
        "id": 1,
        "name": "John Doe Updated",
        "email": "newemail@example.com"
    }
}
```

#### Delete User Account
**DELETE** `/user/profile`

Hapus akun user.

**Request Body:**
```json
{
    "password": "current_password"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Account deleted successfully",
    "data": null
}
```

---

### Favorit Management

#### Get User Favorits
**GET** `/favorit?per_page=15&type=doa`

Get list doa, hadist, atau resource lain yang difavorit user.

**Query Parameters:**
- `per_page` (int, optional): Items per page
- `type` (string, optional): Filter by type (doa, hadist, bacaan, wudu, gerakan_shalat, tata_cara)
- `page` (int, optional): Halaman

**Response (200):**
```json
{
    "success": true,
    "message": "Favorits retrieved successfully",
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "favoritable_type": "App\\Models\\Doa",
            "favoritable_id": 5,
            "favoritable": {
                "id": 5,
                "name": "Doa Pagi",
                "arab": "...",
                "translation": "..."
            },
            "created_at": "2026-02-20T10:00:00Z"
        }
    ],
    "pagination": {...}
}
```

#### Add to Favorits
**POST** `/favorit`

Tambahkan resource ke favorit.

**Request Body:**
```json
{
    "type": "doa",
    "id": 5
}
```

**Accepted Types:**
- `doa`
- `hadist`
- `bacaan`
- `wudu`
- `gerakan_shalat`
- `tata_cara`

**Response (201):**
```json
{
    "success": true,
    "message": "Added to favorits successfully",
    "data": null
}
```

**Errors:**
- `400`: Already added to favorits

#### Remove from Favorits
**DELETE** `/favorit/{id}`

Hapus dari favorit.

**Response (200):**
```json
{
    "success": true,
    "message": "Removed from favorits successfully",
    "data": null
}
```

---

### Hijri Pinned Days

#### Get User Pinned Days
**GET** `/hijri/pinned-days`

Get daftar hari-hari penting yang dipinkan user.

**Response (200):**
```json
{
    "success": true,
    "message": "Pinned days retrieved successfully",
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "hijri_date": "1445-09-01",
            "title": "Ramadan Starts",
            "description": "Mulai bulan Ramadan",
            "created_at": "2026-02-20T10:00:00Z",
            "updated_at": "2026-02-20T10:00:00Z"
        }
    ]
}
```

#### Add Pinned Day
**POST** `/hijri/pinned-days`

Tambahkan hari penting ke pinned days.

**Request Body:**
```json
{
    "hijri_date": "1445-09-01",
    "title": "Ramadan Starts",
    "description": "Mulai bulan Ramadan (optional)"
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "Pinned day added successfully",
    "data": {
        "id": 1,
        "user_id": 1,
        "hijri_date": "1445-09-01",
        "title": "Ramadan Starts",
        "description": "Mulai bulan Ramadan",
        "created_at": "2026-02-20T10:00:00Z"
    }
}
```

#### Delete Pinned Day
**DELETE** `/hijri/pinned-days/{id}`

Hapus hari dari pinned days.

**Response (200):**
```json
{
    "success": true,
    "message": "Pinned day deleted successfully",
    "data": null
}
```

---

## Response Format

### Success Response
```json
{
    "success": true,
    "message": "Success message",
    "data": {}
}
```

### Paginated Response
```json
{
    "success": true,
    "message": "Success message",
    "data": [],
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

### Error Response
```json
{
    "success": false,
    "message": "Error message"
}
```

### Validation Error Response
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required"],
        "password": ["The password must be at least 8 characters"]
    }
}
```

---

## Error Handling

### HTTP Status Codes

| Code | Meaning |
|------|---------|
| 200 | OK - Request berhasil |
| 201 | Created - Resource berhasil dibuat |
| 400 | Bad Request - Request tidak valid |
| 401 | Unauthorized - Token invalid atau expired |
| 404 | Not Found - Resource tidak ditemukan |
| 422 | Unprocessable Entity - Validation error |
| 500 | Internal Server Error - Server error |

### Common Error Messages

**Unauthorized (401):**
```json
{
    "success": false,
    "message": "Unauthorized"
}
```

**Validation Error (422):**
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "field_name": ["Error message"]
    }
}
```

**Not Found (404):**
```json
{
    "success": false,
    "message": "Resource not found"
}
```

---

## Usage Examples

### cURL

#### Login
```bash
curl -X POST https://your-domain.com/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

#### Get Doas with Token
```bash
curl -X GET https://your-domain.com/api/v1/doas \
  -H "Authorization: Bearer your_token_here"
```

#### Add to Favorit
```bash
curl -X POST https://your-domain.com/api/v1/favorit \
  -H "Authorization: Bearer your_token_here" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "doa",
    "id": 5
  }'
```

### JavaScript/Fetch

```javascript
// Login
const loginResponse = await fetch('https://your-domain.com/api/v1/auth/login', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    email: 'john@example.com',
    password: 'password123'
  })
});

const { data: { token } } = await loginResponse.json();

// Get doas
const doasResponse = await fetch('https://your-domain.com/api/v1/doas', {
  headers: {
    'Authorization': `Bearer ${token}`
  }
});

const doas = await doasResponse.json();
console.log(doas);
```

### Dart/Flutter

```dart
// Using http package
import 'package:http/http.dart' as http;

// Login
final loginResponse = await http.post(
  Uri.parse('https://your-domain.com/api/v1/auth/login'),
  headers: {'Content-Type': 'application/json'},
  body: jsonEncode({
    'email': 'john@example.com',
    'password': 'password123'
  }),
);

final loginData = jsonDecode(loginResponse.body);
String token = loginData['data']['token'];

// Get doas
final doasResponse = await http.get(
  Uri.parse('https://your-domain.com/api/v1/doas'),
  headers: {'Authorization': 'Bearer $token'},
);

final doas = jsonDecode(doasResponse.body);
print(doas);
```

---

## Notes

- Semua timestamp menggunakan format ISO 8601 (UTC)
- Token berlaku selamanya sampai di-logout
- Gunakan `per_page` dan `page` untuk pagination
- Untuk resource yang belum ada atau belum ada endpoint, akan dikembangkan sesuai kebutuhan

---

## Support & Issues

Jika mengalami masalah dengan API, silakan hubungi tim development atau buat issue di repository project.
