<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aida Pratama</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <style>
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp { animation: fadeInUp 0.8s ease-out both; }
    .product-card {
      width: 250px;
      max-width: 90vw;
      min-width: 180px;
      background: rgba(255,255,255,0.82);
      border-radius: 1.25rem;
      box-shadow: 0 4px 24px 0 rgba(0,0,0,0.08);
      border: 1px solid #e5e7eb;
      transition: box-shadow 0.2s, filter 0.2s, transform 0.2s;
      display: flex;
      flex-direction: column;
      backdrop-filter: blur(2px);
    }
    .btn-lihat {
      background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
      color: #fff;
      border-radius: 9999px;
      padding: 0.5rem 1.5rem;
      font-weight: 600;
      box-shadow: 0 2px 8px 0 rgba(37,99,235,0.10);
      transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
      outline: none;
      border: none;
      font-size: 1rem;
      letter-spacing: 0.01em;
      margin-top: auto;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }
    .btn-lihat:hover, .btn-lihat:focus {
      background: linear-gradient(90deg, #1e40af 0%, #2563eb 100%);
      box-shadow: 0 4px 16px 0 rgba(37,99,235,0.18);
      transform: translateY(-2px) scale(1.04);
    }
    .product-desc {
      color: #64748b;
      font-size: 0.97rem;
      font-weight: 400;
      line-height: 1.5;
      padding: 0.25rem 0.5rem 0.5rem 0.5rem;
      border-radius: 0.5rem;
      background: rgba(243,244,246,0.5);
      margin-bottom: 1rem;
      min-height: 48px;
    }
    .swiper-slide:not(.swiper-slide-active) {
      cursor: pointer;
    }
  </style>
</head>
<body class="bg-white text-gray-800">

  <!-- Hero Section -->
  <header class="bg-gradient-to-r from-blue-500 to-blue-600 text-white py-20">
    <div class="container mx-auto text-center px-4">
      <h1 class="text-4xl md:text-6xl font-bold mb-4 animate-fadeInUp">Toko Grosir Modern & Terpercaya</h1>
      <p class="text-lg md:text-2xl mb-8 animate-fadeInUp" style="animation-delay: 0.3s;">
        Produk berkualitas & harga kompetitif untuk kebutuhan usaha Anda
      </p>
      <a href="#produk" class="bg-white text-blue-600 font-semibold py-3 px-6 rounded-full shadow-lg hover:bg-gray-100 transition animate-fadeInUp" style="animation-delay: 0.6s;">
        Jelajahi Produk
      </a>
    </div>
  </header>

  <!-- Features Section -->
  <section id="features" class="py-16">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center animate-fadeInUp">
          <div class="mx-auto bg-blue-100 text-blue-600 rounded-full w-16 h-16 flex items-center justify-center mb-4">
            🛒
          </div>
          <h3 class="font-semibold text-xl mb-2">Pilihan Lengkap</h3>
          <p>Kami sediakan ribuan produk grosir siap kirim.</p>
        </div>
        <div class="text-center animate-fadeInUp" style="animation-delay:0.2s;">
          <div class="mx-auto bg-blue-100 text-blue-600 rounded-full w-16 h-16 flex items-center justify-center mb-4">
            🤝
          </div>
          <h3 class="font-semibold text-xl mb-2">Layanan Profesional</h3>
          <p>Tim support siap bantu kamu 24/7.</p>
        </div>
        <div class="text-center animate-fadeInUp" style="animation-delay:0.4s;">
          <div class="mx-auto bg-blue-100 text-blue-600 rounded-full w-16 h-16 flex items-center justify-center mb-4">
            🚚
          </div>
          <h3 class="font-semibold text-xl mb-2">Pengiriman Cepat</h3>
          <p>Logistik terpercaya menjangkau seluruh Indonesia.</p>
        </div>
      </div>
    </div>
  </section>

<!-- Produk Section -->
<section id="produk" class="py-16 bg-gray-100">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-center mb-12">Produk Unggulan</h2>
    
    <div class="relative">
      <!-- Swiper Carousel container -->
      <div class="swiper mySwiper pb-8">
        <div class="swiper-wrapper">
          @foreach($products as $product)
            @if($product->stock < 10)
              <div class="swiper-slide product-card animate-fadeInUp">
                <img src="{{ $product->image_url ?? 'https://placehold.co/600x400' }}" alt="{{ $product->name }}" class="rounded-t-2xl w-full h-40 object-cover">
                <div class="p-4 flex-1 flex flex-col">
                  <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                  <p class="product-desc flex-1">{{ $product->sku }}</p>
                  <button class="btn-lihat">Lihat</button>
                </div>
              </div>
            @endif
          @endforeach
        </div>
        <!-- Swiper navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
      </div>
      <script>
        const swiper = new Swiper('.mySwiper', {
          effect: 'coverflow',
          grabCursor: true,
          centeredSlides: true,
          slidesPerView: '3',
          initialSlide: 0,
          loop: true,
          spaceBetween: 32, // jarak antar card
          coverflowEffect: {
            rotate: 0,
            stretch: 0,
            depth: 180,
            modifier: 1.2,
            slideShadows: false,
          },
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
          pagination: {
            el: '.swiper-pagination',
            clickable: true,
          },
        });

        // Efek blur & scale, pastikan transform tidak menumpuk
        function updateSlideEffects() {
          swiper.slides.forEach((slide) => {
            slide.style.transform = slide.style.transform.replace(/scale\([^)]*\)/, '');
            const slideProgress = slide.progress;
            if (Math.abs(slideProgress) > 0.7) {
              slide.style.filter = 'blur(2.5px) brightness(0.92)';
              slide.style.transform += ' scale(0.8)';
              slide.style.zIndex = 1;
            } else if (Math.abs(slideProgress) > 0.3) {
              slide.style.filter = 'blur(1.2px) brightness(0.97)';
              slide.style.transform += ' scale(0.9)';
              slide.style.zIndex = 2;
            } else {
              slide.style.filter = 'none';
              slide.style.transform = slide.style.transform.replace(/scale\([^)]*\)/, '') + ' scale(1)';
              slide.style.zIndex = 3;
            }
          });
        }
        swiper.on('setTranslate', updateSlideEffects);
        swiper.on('slideChange', updateSlideEffects);
        setTimeout(updateSlideEffects, 100);
      </script>
    </div>
  </div>
</section>


  <!-- CTA Section -->
  <section class="py-16">
    <div class="container mx-auto px-4 text-center">
      <h2 class="text-3xl font-bold mb-4 animate-fadeInUp">Ingin jadi reseller?</h2>
      <p class="mb-8 animate-fadeInUp" style="animation-delay:0.2s;">
        Daftar sekarang dan nikmati harga khusus partner bisnis.
      </p>
      <a href="#kontak" class="bg-blue-600 text-white font-semibold py-3 px-8 rounded-full shadow-lg hover:bg-blue-700 transition animate-fadeInUp" style="animation-delay:0.4s;">
        Daftar Reseller
      </a>
    </div>
  </section>

  <!-- Kontak Section -->
  <footer id="kontak" class="bg-blue-600 text-white py-12">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="animate-fadeInUp">
        <h4 class="font-semibold text-xl mb-2">Kontak Kami</h4>
        <p>Jl. Contoh No.123, Kota Anda</p>
        <p>Email: info@toko-grosir.com</p>
        <p>Telp: 0812-3456-7890</p>
      </div>
      <div class="animate-fadeInUp" style="animation-delay:0.2s;">
        <h4 class="font-semibold text-xl mb-2">Jam Operasional</h4>
        <p>Sen–Sab: 08.00–18.00</p>
        <p>Minggu: Tutup</p>
      </div>
      <div class="animate-fadeInUp" style="animation-delay:0.4s;">
        <h4 class="font-semibold text-xl mb-2">Follow Kami</h4>
        <div class="flex space-x-4 text-2xl">
          <a href="#" aria-label="Instagram">📸</a>
          <a href="#" aria-label="Facebook">👍</a>
          <a href="#" aria-label="WhatsApp">💬</a>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>
