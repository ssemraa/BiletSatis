
# 🎫 Bilet Satın Alma Uygulaması

Bu proje, kullanıcıların etkinlikleri inceleyip sepete ekleyerek bilet satın alabilecekleri bir Laravel tabanlı web uygulamasıdır. Kullanıcı paneli, admin paneli ve ödeme işlemleri gibi özellikler içerir.

---

## 📌 Proje Amacı

Kullanıcıların çeşitli etkinlikleri (konser, tiyatro vb.) görüntüleyip sepetlerine ekledikten sonra bilet satın alabilecekleri bir sistem oluşturmak.

---

## 🛠️ Kullanılan Teknolojiler

### Backend
- PHP (Laravel 10)
- Laravel Routing, Controller, Middleware

### Frontend
- Blade Template Engine
- HTML / CSS / JavaScript

### Veritabanı
- MySQL

### Oturum Yönetimi
- Laravel Session

---

## 📸 Uygulama Ekranları ve Açıklamaları

### 1. Giriş Ekranı
Kullanıcılar, e-posta ve şifre bilgileriyle sisteme giriş yapar. Başarılı giriş sonrası anasayfaya yönlendirilir.

### 2. Kayıt Ekranı
Yeni kullanıcıların sisteme kayıt olabileceği ekrandır. Kayıt sonrası kullanıcı onay bekler.

### 3. Anasayfa
Etkinlikler listelenir. Her etkinlik kartında "Sepete Ekle" butonu bulunur.

### 4. Etkinlikler Sayfası
Etkinlik detayları, fiyat ve açıklama bilgilerinin yer aldığı dinamik bir liste ekranıdır.

### 5. Sepet Sayfası
Sepete eklenen ürünler listelenir. Adet arttırma/azaltma, silme ve ödeme adımına geçme işlemleri yapılabilir.

### 6. Ödeme Ekranı
Kullanıcılar ödeme yöntemi seçerek işlemi tamamlar. Uygun giriş yapılmadığında sistem kullanıcıyı uyarır.

### 7. Ödeme Onayı Ekranı
Ödeme başarılıysa kullanıcıya bilgi verilir, sepet temizlenir, stok güncellenir.

### 8. Admin Paneli
Yalnızca admin tarafından erişilir. Kullanıcı onaylama, etkinlik ve duyuru ekleme/silme işlemleri yapılabilir.

---

## 🗃️ Veritabanı Tasarımı

### Veritabanı
- MySQL kullanılmıştır.
- `.env` dosyası ile bağlantı sağlanır.

### Bağlantı Ayarları (örnek)
```
DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=laravel  
DB_USERNAME=root  
DB_PASSWORD=
```

### Modeller
- `User`: Kullanıcı kayıt ve onay işlemleri
- `Event`: Etkinlik ve stok işlemleri

---

## ▶️ Kurulum ve Çalıştırma

### 1. Projeyi klonlayın:
```bash
git clone https://github.com/ssemraa/BiletSatis.git

```

### 2. Bağımlılıkları yükleyin:
```bash
composer install
```

### 3. Ortam dosyasını oluşturun:
```bash
cp .env.example .env
```
`.env` dosyasındaki veritabanı bilgilerini kendi sisteminize göre güncelleyin.

### 4. Uygulama anahtarını oluşturun:
```bash
php artisan key:generate
```

### 5. Migrationları çalıştırın:
```bash
php artisan migrate
```

### 6. Sunucuyu başlatın:
```bash
php artisan serve
```

### 7. Tarayıcıdan uygulamayı açın:
[http://localhost:8000](http://localhost:8000)

---

## 🌐 Proje Kaynak Kodu

🔗 GitHub: (https://github.com/ssemraa/BiletSatis)

---

## 🧑‍💻 Geliştirici Notu

Bu proje, Laravel öğrenimi ve web uygulama geliştirme pratiği amacıyla hazırlanmıştır. Katkıda bulunmak isterseniz PR'larınızı bekleriz!
