# To'lov Tizimi Integratsiyasi Qo'llanmasi (Payme, Click, Paynet)

Ushbu hujjat Laravel loyihasida to'lov tizimlarini (Factory Pattern bo'yicha) qanday ishlatish va barcha API so'rovlarni o'z ichiga oladi.

## 1. Sozlamalar (Configuration)
Payme bilan to'g'ri ishlash uchun loyihangizdagi `.env` fayliga quyidagi o'zgaruvchilarni qo'shishingiz kerak:
```env
PAYME_ID=your_payme_merchant_id
PAYME_KEY=your_payme_secret_key
PAYME_URL=https://checkout.test.paycom.uz/api
PAYME_TEST_MODE=true
```
> **Eslatma:** Test rejimida `PAYME_URL` manzili ko'rsatilganidek qoladi. Asosiy (production) rejimga o'tganda manzilni va kalitlarni yangilashni unutmang.

## 2. Ma'lumotlar bazasi (Models va Migrations)
- **Order**: Foydalanuvchi buyurtmalarini saqlash uchun.
- **Card**: Foydalanuvchining to'lov tizimidan muvaffaqiyatli ro'yxatdan o'tgan plastik kartalarini saqlash uchun.
- **Transaction**: To'lov tranzaksiyalari (kirimi, chiqimi va to'lov holati) bo'yicha ma'lumotlar saqlanadi.

## 3. Tranzaksiya holatlari (Status Enum)
Tranzaksiya holatlari maxsus ENUM (`App\Enums\TransactionStatusEnum`) orqali boshqariladi:
- `PENDING` - To'lov kutilmoqda.
- `PROCESSING` - Jarayonda (Karta tasdiqlanmoqda yoki to'lov amalga oshirilmoqda).
- `PAID` - Muvaffaqiyatli to'langan.
- `CANCELLED` - Bekor qilingan.
- `FAILED` - Xatolik yuz berdi.

---

## 4. API Endpoints (So'rovlar va Javoblar)
To'lov jarayoni uchun quyidagi API endpointlar `routes/api.php` da `v1` prefiksi ostida tayyorlandi. Barcha URL larda `{provider}` parametri qaysi to'lov tizimidan foydalanilayotganini bildiradi (masalan: `payme`, `click`, `paynet`). Ushbu yo'nalishlarga so'rov yuborish uchun **Bearer Token** zarur (Webhookdan tashqari).

### 4.1. Karta qo'shish
Kartani to'lov tizimiga ulash va OTP tasdiqlash uchun token olish.
- **URL**: `POST /api/v1/payment/{provider}/cards`
- **Auth**: `Bearer Token`
- **Request Body (JSON)**:
  ```json
  {
      "card_number": "8600123456789012",
      "expire": "12/24"
  }
  ```
- **Response (200 OK)**:
  ```json
  {
      "success": true,
      "data": {
          "card_id": 1,
          "token": "a1b2c3d4e5f6g7h8.payme_token",
          "phone": "998901234567",
          "wait": 60000
      },
      "message": "Success"
  }
  ```

### 4.2. Kartani tasdiqlash (OTP Verify)
Telefon raqamga kelgan SMS kod (OTP) orqali kartani tasdiqlash.
- **URL**: `POST /api/v1/payment/{provider}/cards/verify`
- **Auth**: `Bearer Token`
- **Request Body (JSON)**:
  ```json
  {
      "card_id": 1,
      "token": "a1b2c3d4e5f6g7h8.payme_token",
      "code": "123456"
  }
  ```
- **Response (200 OK)**:
  ```json
  {
      "success": true,
      "data": {
          "message": "Karta tasdiqlandi!",
          "is_verified": true
      },
      "message": "Success"
  }
  ```

### 4.3. To'lovni amalga oshirish
Buyurtma (Order) va tasdiqlangan karta asosida to'lov qilish.
- **URL**: `POST /api/v1/payment/{provider}/pay`
- **Auth**: `Bearer Token`
- **Request Body (JSON)**:
  ```json
  {
      "order_id": 123,
      "card_id": 1
  }
  ```
- **Response (200 OK)**:
  ```json
  {
      "success": true,
      "data": {
          "transaction_id": 5,
          "status": "Тўланган",
          "amount": 150000
      },
      "message": "Success"
  }
  ```

### 4.4. To'lovni bekor qilish
O'tkazilgan to'lovni (cheknI) bekor qilish.
- **URL**: `DELETE /api/v1/payment/{provider}/transactions/{id}/cancel`
  *(Bunda `{id}` tranzaksiyaning ID raqami)*
- **Auth**: `Bearer Token`
- **Request Body**: `Bo'sh`
- **Response (200 OK)**:
  ```json
  {
      "success": true,
      "data": {
          "status": "Бекор қилинган",
          "message": "To'lov bekor qilindi"
      },
      "message": "Success"
  }
  ```

### 4.5. Webhook (Server-to-Server)
To'lov tizimidan keladigan so'rovlar (masalan CreateTransaction, PerformTransaction) ni qabul qilish. Ushbu manzilni To'lov Merchant Cabinet (misol uchun, Payme biznes kabineti) sozlamalaridan kiritib qo'yish talab etiladi.
- **URL**: `POST /api/v1/payment/{provider}/webhook`
- **Auth**: `Basic Auth` (Payme yoki Click tomonidan yuboriladi, dastur konfiguratsiyasi orqali tekshiriladi).
- **Misol URL (Payme uchun)**: `https://yourdomain.uz/api/v1/payment/payme/webhook`
- **Muhim**: Ushbu qism avtorizatsiya talab qilmaydi, `routes/api.php` da auth middleware tashqarisida joylashgan.

---

## 5. Xizmatlar (Services) va Factory Architecture
Loyihada kengaytiriladigan **Factory Pattern** o'rnatilgan:
- Barcha amallar bitta Endpoint guruhi: `PaymentController` orqali marshrut qilinadi.
- `PaymentFactory` `{provider}` dan kelgan satrga qarab kerakli servisni chaqiradi (`PaymeProvider`, `ClickProvider`, `PaynetProvider`).
- Barcha providerlar yagona `PaymentProviderInterface` shartnomasini bajarishga majbur etiilgan. Yordamchi servislar `app/Services/Common/Payment/Providers` manzilida yotibdi. 

Bu arxitektura kelajakda boshqa to'lov tizimlarini juda oson ulash imkonini beradi. Yangi provider yaratiladi va Factory ga qo'shib qo'yiladi xolos, Controller va Frontend API o'zgarmaydi.

---

## 6. To'lov Jarayoni Qanday Ishlaydi? (Qadamma-qadam)

Mijoz frontend ilovasida **"To'lash"** tugmasini bosganida aylanib o'tadigan jarayon quyidagicha kechadi. Misol uchun `order_id=1` va `card_id=5` raqamli tranzaksiya:

**1. So'rov Kelib Tushishi (API Endpoint)**  
Frontend yoki mijoz tomonidan loyihaga POST so'rov keladi:  
`POST /api/v1/payment/payme/pay`
```json
{
    "order_id": 1,
    "card_id": 5
}
```

**2. Controller: Marshrutlash**  
So'rov birinchi bo'lib `PaymentController` dagi `pay()` metodiga yetib boradi. URL dagi `{provider}` parametri (ya'ni `payme`) parametrdan olinib, aynan qaysi tizimga ulanish kerakligi aniqlanadi.

**3. Factory: Kerakli To'lov Tizimini Tanlash**  
`PaymentFactory` `"payme"` qiymatini o'qiydi va dasturga xotiradan **`PaymeProvider`** obyektini yaratib beradi. Barcha keyingi mantiq shu maxsus provider ichida bajariladi.

**4. Provider: To'lovni Boshlash va Tekshiruvlar**  
Controller `PaymeProvider` dagi `initiatePayment()` funksiyasini chaqiradi:
- Model orqali buyurtma (Order) va ulangan karta (Card) bazadan chaqiriladi.
- Karta to'liq tasdiqlanganligi (OTP kiritilganligi) tekshiriladi (`is_verified = true`).
- Baza (`transactions` jadvali) da yangi to'lov yozuvi yaratiladi va uning holati boshlang'ich **`PENDING`** (Kutilmoqda) deb e'lon qilinadi.

**5. ⚡️ Payme API ga Birinchi Murojaat: Chek Yaratish**  
Tasdiqlangan kartadan pulni yechib olish uchun Payme tizimida oldin elektron "chek" tayyorlash lozim:
- `PaymeProvider` yordamchi `PaymeService` ni yordamga chaqiradi.
- `PaymeService` aynan **Payme serveriga** HTTP `POST https://checkout.test.paycom.uz/api` so'rovini jo'natadi. Tashqi tizimga yuboriladigan rpc buyruq: `receipts.create`.
- Payme bunga javoban bizga tayyor `receipt_id` (chek ID si) qaytaradi.
- Biz bu chek raqamini loyihamiz bazasiga saqlaymiz va tranzaksiya holatini **`PROCESSING`** (Jarayonda) ga o'zgartiramiz. *(Diqqat! Pul hali yechilmadi)*.

**6. ⚡️ Payme API ga Ikkinchi Murojaat: Pul Yechish**  
Chek raqami tayyor bo'lgach, pulni haqiqiy yechib olish uchun ikkinchi bor Payme serveriga mudoraaja etiladi:
- `PaymeService` endi Payme ga `receipts.pay` buyrug'i bilan murojaat qilib, maxsus parametr sifatida olingan `receipt_id` va tasdiqlangan kartaning unikal `token` ini berib yuboradi.
- **Aynan shu bosqichda Payme tokenni tasdiqlaydi va xaridorni balansidan pulni yechib oladi.**

**7. Yakuniy Tasdiq (Baza Yangilanishi)**  
Agar Payme API dan "muvaffaqiyatli to'landi" degan xabar (state=4) qaytib kelsa:
- `transactions` jadvalidagi yozuv holati **`PAID`** qilib belgilanadi.  
- Shu tranzaksiyaga tegishli bo'lgan `orders` jadvalidagi buyurtma holati ham mos ravishda `paid` ga o'zgartiriladi.

**8. Klientga Javob Qaytishi**  
Kutish jarayoni to'liq yopilgach ish yana `PaymentController` ga qaytadi. U mijozga qisqa va aniq JSON formatda HTTP 200 javobini yo'llaydi:
```json
{
    "success": true,
    "data": {
        "transaction_id": 12,
        "status": "Тўланган",
        "amount": 150000
    },
    "message": "Success"
}
```

> Ushbu modulli qadamlar orqali To'lov Jarayoni - **Controller** (marshrutchi), **Factory** (tarqatuvchi), **Provider** (baza/yacheyka mantig'i) va **Service** (Faqatgina to'lov API lariga murojaat etuvchi) qatlamlarga bo'lib ishlangan hisoblanadi. Shunday qilib loyiha xavfsiz va tushunishga oson holatga keltirilgan.

---

## 7. `handleWebhook()` — nima qiladi va qanday ishlaydi?

Bu funksiya Payme serveri tomonidan sizning serveringizga yuboriladigan **avtomatik so'rovlarni** qabul qilib, ularga to'g'ri javob qaytarish vazifasini bajaradi. **Siz Paymega so'rov yubormaysiz, Payme sizga so'rov yuboradi, siz javob berasiz.**

### Qanday ishlaydi — oddiy sxema:
```text
1. Foydalanuvchi to'laydi
        ↓
2. Payme serveri ushbu to'lovni tasdiqlaydi
        ↓ (Yashirin webhook - avtomatik so'rov)
3. Sizning serveringiz (handleWebhook) ga xabar beradi
        ↓
4. Serveringiz holatni yangilab, Paymega javob (200 OK) qaytaradi
```

### Funksiya ichidagi 2 ta Asosiy Qism:

**1-qism — Pinhona Autentifikatsiya (Xavfsizlik):**
```php
if (!$this->authenticate($request)) {
    return response()->json([
        'error' => [
            'code'    => -32504,
            'message' => 'Insufficient privilege to perform this method',
        ]
    ], 401);
}
```
*Bu so'rov haqiqatan ham **Paymeden** kelganmi?* degan savolga javob beradi. Agar boshqa birov soxta so'rov yuborsa — tizim uni avtomatik ravishda bloklaydi va `401 Unauthorized` qaytaradi. Bunga `.env` faylidagi `PAYME_KEY` asos bo'lib xizmat qiladi.

**2-qism — Method Routing (Yo'naltirish):**
```php
$method = $request->input('method'); // Payme qaysi amalni bajarish kerakligini aytadi

return match($method) {
    'CheckPerformTransaction' => $this->checkPerformTransaction($params),
    'CreateTransaction'       => $this->createTransaction($params),
    'PerformTransaction'      => $this->performTransaction($params),
    'CancelTransaction'       => $this->cancelTransaction($params),
    'CheckTransaction'        => $this->checkTransaction($params),
    'GetStatement'            => $this->getStatement($params),
    default                   => $this->methodNotFound(),
};
```
Payme sizdan nima xohlayotganiga qarab so'rovni tegishli izolyatsiyalangan funksiyaga jo'natadi.

---

### Har bir metod nima qiladi?

| Method | Qachon chaqiriladi? | Sizig vazifangiz nima? |
|---|---|---|
| `CheckPerformTransaction` | To'lovdan **oldin** | "Bu buyurtma ID si bazada haqiqatan bormi va summasi to'g'rimi?" — tekshirib Paymega ruxsat berish. |
| `CreateTransaction` | To'lov **boshlanayotganda** | DB dagi `transactions` jadvaliga yozuv yaratish. |
| `PerformTransaction` | To'lov **muvaffaqiyatli** bo'lganda! | To'lov amalga oshdi! Buyurtma va Tranzaksiya holatini "to'langan" (`paid`) deb belgilash. |
| `CancelTransaction` | To'lov **bekor qilinganda** | Karta muammosi yoki qaytarish payti: Buyurtmani "bekor qilingan" (`cancelled`) qilish. |
| `CheckTransaction` | Payme **holatni so'raganda** | Uzoq vaqtli jarayonda Transaction statusesini va vaqtlarini json qilib qaytarib berish. |
| `GetStatement` | Payme xisobot so'rasa | Belgilangan vaqt oralig'idagi barcha muvaffaqiyatli to'lovlar listini berish (Hozircha bo'sh). |

---

### 🌐 Real Hayotdagi Zanjir (Buyurtma to'lash xronologiyasi):

1. **Foydalanuvchi "To'lash" tugmasini bosadi.**
2. **Payme → `CheckPerformTransaction` yuboradi:** 
   *"Bu №123 order sizda mavjudmi? Kiritilgan summa to'g'rimi?"*
3. **Siz → "Ha, mavjud, o'tkazing."** deb ruxsat javobini berasiz.
4. **Payme → `CreateTransaction` yuboradi:** 
   *"O'zimda Transaction varag'i yaratdim. ID si 555xxxx. Sizda ham shuni yarating."*
5. **Siz → DB ga vaqtni yozasiz, "OK saqladim"** deb javob berasiz.
6. **Mijoz telefonida SMS kodini kiritadi va karta hisobidan pul yechiladi.**
7. **Payme → `PerformTransaction` yuboradi:** 
   *"Pul muvaffaqiyatli olindi! Endi o'zingizda Order qatorini muvaffaqiyatli deb e'lon qiling!"*
8. **Siz → DB da Order statusini `paid` qilasiz ✅.**

### 🤔 Nega umuman Webhook kerak?

> ❌ **Webhooksiz hayot:** Foydalanuvchi Saytingizda kod kiritadi, pul yechiladi.. lekin u sahifani yopib yuboradi yoki interneti o'chadi. Serveringiz esa *"To'lov bo'ldimi o'zi yoqmi?"* deb kutaveradi. Buyurtma umrbod `pending` holatida qolib ketadi.
> 
> ✅ **Webhookli hayot:** Foydalanuvchi nima qilsa ham farqi yo'q. Payme serveri 1 soniya ichida to'lov bo'lgani haqidagi habarni orqavarotdan sizning serveringizga yetkazadi. Buyurtma ishonchli ravishda `paid` bo'ladi.
