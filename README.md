# Loyihani O'rnatish va Ishga Tushirish Yo'riqnomasi

Ushbu loyiha **Laravel 12**, **Vue 3 (Inertia.js)** va **Vite** asosida qurilgan. Loyihani yangi o'rnatganda quyidagi buyruqlarni ketma-ket bajaring:

### 1. Docker konteynerlarini ishga tushirish
```bash
cd docker
docker compose up -d --build
cd ..
```

### 2. PHP kutubxonalarini o'rnatish
```bash
composer install
```

### 3. JavaScript kutubxonalarini o'rnatish
```bash
npm install
```

### 4. Muhit faylini sozlash
`.env.example` faylidan nusxa olib, `.env` faylini yarating:
```bash
cp .env.example .env
```
*Eslatma: `.env` faylini ochib, undagi `DB_DATABASE`, `DB_USERNAME` va `DB_PASSWORD` qismlarini o'zingizning bazangizga moslab sozlang.*

### 5. Ilova kalitini generatsiya qilish
```bash
php artisan key:generate
```

### 6. Ma'lumotlar bazasini tayyorlash
Migratsiyalarni yurgizish va kerakli rollar/foydalanuvchilarni (seeders) bazaga yozish:
```bash
php artisan migrate
php artisan db:seed
```

### 7. Fayllar uchun havola yaratish (Storage Link)
```bash
php artisan storage:link
```

### 8. Loyihani ishga tushirish
Local serverni va Vite (frontend)ni bir vaqtda ishga tushirish uchun:
```bash
npm run dev
```

---

### Qo'shimcha ma'lumotlar:
- **Admin paneli**: Loyihada RBAC (Role-Based Access Control) bor. Seed qilinganidan so'ng, admin foydalanuvchisi avtomatik yaratiladi.
- **Elasticsearch**: Loyihada Elasticsearch sozlamalari mavjud. Agar qidiruv tizimi ishlatilsa, Elasticsearch servisi yoqilgan bo'lishi kerak.
