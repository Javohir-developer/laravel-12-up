# RBAC (Role-Based Access Control) Tizimi Qo'llanmasi

Ushbu loyihada foydalanuvchi huquqlarini boshqarish uchun **Spatie Laravel Permission** paketi asosida RBAC tizimi o'rnatildi. Quyida tizimning ishlash printsipi, yaratilgan fayllar va konfiguratsiyalar haqida to'liq ma'lumot berilgan.

## 1. O'rnatish va Konfiguratsiya

### Paket o'rnatilishi
Tizimga quyidagi buyruq orqali paket qo'shilgan:
```bash
composer require spatie/laravel-permission
```

### Migratsiyalar
Ma'lumotlar bazasida rollar va ruxsatlarni saqlash uchun quyidagi jadvallar yaratildi:
- `roles` (rollar ro'yxati)
- `permissions` (ruxsatlar ro'yxati)
- `model_has_roles` (foydalanuvchilarga rollarni biriktirish)
- `role_has_permissions` (rollarga ruxsatlarni biriktirish)

### Middleware (Himoya) ro'yxatdan o'tkazilishi
`bootstrap/app.php` faylida Spatie-ning himoya qatlamlari (middleware) quyidagi nomlar bilan ro'yxatdan o'tkazildi:
- `role` -> `RoleMiddleware`
- `permission` -> `PermissionMiddleware`
- `role_or_permission` -> `RoleOrPermissionMiddleware`

## 2. Model va Ma'lumotlar Bazasini Tayyorlash

### User Modeli
`app/Models/User.php` fayliga `HasRoles` treyti qo'shildi. Bu foydalanuvchi ob'ekti orqali rollar bilan ishlash imkonini beradi:
```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    use HasRoles;
    // ...
}
```

### Roles and Permissions Seeder
Boshlang'ich rollarni (admin, user) va ruxsatlarni yaratish uchun `database/seeders/RolesAndPermissionsSeeder.php` fayli yaratildi. 
Ishga tushirish:
```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

## 3. Backend (Kontrollerlar va Marshrutlar)

Barcha foydalanuvchi va rollarni boshqarish kontrollerlari `app/Http/Controllers/App/Users/` papkasiga jamlandi.

### Kontrollerlar:
1. **RoleController**: Rollarni yaratish, tahrirlash (ruxsatlar bilan birga) va o'chirish.
2. **UserRoleController**: Foydalanuvchilar ro'yxati, yangi user yaratish, userni tahrirlash (ism, email va rollar) hamda o'chirish.
3. **ProfileController**: Foydalanuvchining shaxsiy profil ma'lumotlarini boshqarish.

### Marshrutlar (Routes):
`routes/web.php` faylida barcha RBAC marshrutlari `role:admin` middleware-i bilan himoyalangan. Ya'ni bu bo'limlarga faqat **admin** roliga ega shaxslargina kira oladi.

## 4. Frontend (Vue.js + Inertia.js)

### Sahifalar (Pages):
- `resources/js/Pages/Roles/`: Rollar jadvali va formalar.
- `resources/js/Pages/Users/`: Foydalanuvchilar jadvali va tahrirlash oynasi.

### AdminLayout (Menyu himoyasi):
`resources/js/Layouts/AdminLayout.vue` faylida menyudagi "Users" va "Roles" ssilkalari faqat adminlar uchun ko'rinadigan qilindi:
```html
<Link v-if="$page.props.auth.user.roles.includes('admin')" :href="route('users.index')">
    Users
</Link>
```

### Inertia Share (Ma'lumot uzatish):
Foydalanuvchi rollarini Vue sahifalarida tekshirish uchun `app/Http/Middleware/HandleInertiaRequests.php` faylida joriy foydalanuvchining rollari (roles) global prop sifatida qo'shildi.

## 5. Tizimdan Foydalanish

1. **Yangi Rol yaratish**: "Roles" menyusiga kiring va "Create Role" knopkasini bosing. Rolga tegishli ruxsatlarni (permissions) belgilang.
2. **Foydalanuvchiga Rol berish**: "Users" ro'yxatidan kerakli foydalanuvchini toping va "Edit" knopkasini bosing. Checkboxlar orqali unga kerakli rollarni biriktiring.
3. **Xavfsizlik**: Agar oddiy foydalanuvchi `/users` yoki `/roles` manzillariga qo'lda g'irromlik qilib kirishga urinsa, Laravel uni avtomatik to'xtatadi (403 Forbidden).

---
*Ushbu hujjat RBAC tizimi loyihaga qanday integratsiya qilinganini tushunishga yordam beradi.*
