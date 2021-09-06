-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 05 Eyl 2021, 17:46:59
-- Sunucu sürümü: 10.2.40-MariaDB-cll-lve
-- PHP Sürümü: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `noxuscho_menu`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

CREATE TABLE `ayarlar` (
  `a_id` int(11) NOT NULL,
  `a_logo` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `a_url` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `a_title` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `a_description` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `a_keywords` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `a_author` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `a_firmaad` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `silindimi` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gelir`
--

CREATE TABLE `gelir` (
  `g_id` int(100) NOT NULL,
  `toplam` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `tarih` date NOT NULL,
  `silindimi` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gider`
--

CREATE TABLE `gider` (
  `g_id` int(100) NOT NULL,
  `turu` int(10) NOT NULL,
  `toplam` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `maas` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `aciklama` varchar(500) COLLATE utf8mb4_turkish_ci NOT NULL,
  `tarih` date NOT NULL,
  `silindimi` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `giderturu`
--

CREATE TABLE `giderturu` (
  `g_id` int(100) NOT NULL,
  `ad` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `silindimi` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategori`
--

CREATE TABLE `kategori` (
  `kt_id` int(11) NOT NULL,
  `kt_ad` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(1) NOT NULL DEFAULT 1,
  `sira` int(10) NOT NULL,
  `kt_yukseklik` int(10) NOT NULL,
  `silindimi` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

CREATE TABLE `kullanici` (
  `k_id` int(10) NOT NULL,
  `k_ad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `k_soyad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `k_email` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `k_parola` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `k_salt` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `k_yetki` int(2) NOT NULL DEFAULT 1,
  `durum` int(1) NOT NULL DEFAULT 1,
  `k_yeniuye` int(1) NOT NULL DEFAULT 1,
  `silindimi` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `u_id` int(11) NOT NULL,
  `u_resim` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `u_ad` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `u_fiyat` varchar(10) COLLATE utf8_turkish_ci NOT NULL,
  `u_kategori` int(10) NOT NULL,
  `u_icerik` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
  `sira` int(10) NOT NULL DEFAULT 0,
  `durum` int(1) NOT NULL DEFAULT 1,
  `silindimi` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yetki`
--

CREATE TABLE `yetki` (
  `y_id` int(10) NOT NULL,
  `y_adi` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `y_yetki` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `silindimi` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yetki`
--

INSERT INTO `yetki` (`y_id`, `y_adi`, `y_yetki`, `silindimi`) VALUES
(1, 'musteri', '{\"temp\":0,\"kullanici\":0,\"ayarlar\":0,\"urunler\":0}', 0),
(2, 'admin', '{\"temp\":1,\"kullanici\":1,\"ayarlar\":1,\"urunler\":1}', 0),
(3, 'mod', '{\"temp\":1,\"kullanici\":0,\"ayarlar\":1,\"urunler\":1}', 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ayarlar`
--
ALTER TABLE `ayarlar`
  ADD PRIMARY KEY (`a_id`);

--
-- Tablo için indeksler `gelir`
--
ALTER TABLE `gelir`
  ADD PRIMARY KEY (`g_id`);

--
-- Tablo için indeksler `gider`
--
ALTER TABLE `gider`
  ADD PRIMARY KEY (`g_id`);

--
-- Tablo için indeksler `giderturu`
--
ALTER TABLE `giderturu`
  ADD PRIMARY KEY (`g_id`);

--
-- Tablo için indeksler `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kt_id`);

--
-- Tablo için indeksler `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`k_id`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`u_id`);

--
-- Tablo için indeksler `yetki`
--
ALTER TABLE `yetki`
  ADD PRIMARY KEY (`y_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `gelir`
--
ALTER TABLE `gelir`
  MODIFY `g_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- Tablo için AUTO_INCREMENT değeri `gider`
--
ALTER TABLE `gider`
  MODIFY `g_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=459;

--
-- Tablo için AUTO_INCREMENT değeri `giderturu`
--
ALTER TABLE `giderturu`
  MODIFY `g_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Tablo için AUTO_INCREMENT değeri `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici`
--
ALTER TABLE `kullanici`
  MODIFY `k_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- Tablo için AUTO_INCREMENT değeri `yetki`
--
ALTER TABLE `yetki`
  MODIFY `y_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
