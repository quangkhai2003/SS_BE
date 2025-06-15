<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyStudy</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- TailwindCSS CDN with custom colors -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sky-bg': '#E6F3FA',
                        'sky-primary': '#1E88E5',
                        'sky-secondary': '#64B5F6',
                        'sky-accent': '#FFCA28',
                        'sky-white': '#FFFFFF',
                        'sky-text': '#0D47A1',
                    },
                    boxShadow: {
                        'soft': '0 4px 12px rgba(0, 0, 0, 0.08)',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                    },
                },
            },
        }
    </script>
    <style>
        html {
            font-family: Figtree, sans-serif;
            scroll-behavior: smooth;
        }
        .bg-dots-darker {
            background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(30, 136, 229, 0.1)'/%3E%3C/svg%3E");
        }
        .carousel-item {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        .carousel-item.active {
            display: block;
            opacity: 1;
        }
        .btn-primary {
            background: linear-gradient(135deg, #1E88E5, #64B5F6);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(30, 136, 229, 0.3);
        }
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #1E88E5;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
    </style>
</head>
<body class="antialiased min-h-screen bg-sky-bg bg-dots-darker selection:bg-sky-accent selection:text-sky-text">
    <!-- Navbar -->
    <nav class="bg-sky-white shadow-soft sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-sky-primary">SkyStudy</span>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="#home" class="nav-link text-sky-text font-semibold text-sm uppercase tracking-wide">Trang chủ</a>
                    <a href="#about" class="nav-link text-sky-text font-semibold text-sm uppercase tracking-wide">Giới thiệu</a>
                    <a href="#download" class="nav-link text-sky-text font-semibold text-sm uppercase tracking-wide">Tải xuống</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Banner Section (Carousel) -->
    <section id="banner" class="relative py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-2xl shadow-soft">
                <!-- Banner Images -->
                <div class="carousel-item active">
                    <img src="/banner/banner1.png" alt="Banner 1" class="w-full h-64 sm:h-80 md:h-[28rem] object-cover">
                </div>
                <div class="carousel-item">
                    <img src="/banner/banner2.png" alt="Banner 2" class="w-full h-64 sm:h-80 md:h-[28rem] object-cover">
                </div>
                <div class="carousel-item">
                    <img src="/banner/banner3.png" alt="Banner 3" class="w-full h-64 sm:h-80 md:h-[28rem] object-cover">
                </div>
                <!-- Navigation Buttons -->
                <button id="prevBtn" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-sky-primary text-sky-white p-3 rounded-full hover:bg-sky-secondary transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextBtn" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-sky-primary text-sky-white p-3 rounded-full hover:bg-sky-secondary transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <!-- Dots -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-3">
                    <span class="dot w-3 h-3 bg-sky-primary rounded-full cursor-pointer transition-all" data-index="0"></span>
                    <span class="dot w-3 h-3 bg-gray-300 rounded-full cursor-pointer transition-all" data-index="1"></span>
                    <span class="dot w-3 h-3 bg-gray-300 rounded-full cursor-pointer transition-all" data-index="2"></span>
                </div>
            </div>
        </div>
    </section>

    <!-- Home Section -->
    <section id="home" class="py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-in">
            <h1 class="text-4xl sm:text-5xl font-bold text-sky-primary leading-tight">Chào mừng đến với SkyStudy</h1>
            <p class="mt-6 text-lg text-sky-text leading-relaxed max-w-2xl mx-auto">
                SkyStudy là ứng dụng học tiếng Anh dành cho trẻ em, được thiết kế sinh động và tương tác để giúp trẻ vừa chơi vừa học. Khám phá những công cụ thú vị để bắt đầu hành trình học tập hiệu quả và vui nhộn!
            </p>
            <a href="#download" class="mt-8 inline-block px-8 py-4 btn-primary text-sky-white font-semibold rounded-xl text-lg shadow-soft">Bắt đầu ngay</a>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="py-20 bg-sky-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in">
            <h2 class="text-3xl sm:text-4xl font-bold text-sky-primary text-center">Giới thiệu</h2>
            <p class="mt-6 text-lg text-sky-text text-center leading-relaxed max-w-3xl mx-auto">
                SkyStudy được phát triển với mục tiêu mang lại một nền tảng học tiếng Anh tương tác, sinh động và dễ tiếp cận cho trẻ em. Ứng dụng kết hợp giữa công nghệ, giáo dục và thiết kế thân thiện với trẻ, giúp các em học từ vựng và luyện nghe – nói thông qua các trò chơi và bài tập đầy thú vị.
            </p>
            <div class="mt-12">
                <h3 class="text-2xl font-semibold text-sky-primary text-center mb-8">Thành viên nhóm</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="p-6 bg-sky-bg rounded-xl shadow-soft hover:scale-[1.02] transition-all">
                        <h4 class="text-lg font-semibold text-sky-primary">PT Hưng – “The Architect” 🏗️</h4>
                        <p class="mt-2 text-sky-text">Lập trình viên backend chính, xây hệ thống vững như bê tông cốt thép.</p>
                    </div>
                    <div class="p-6 bg-sky-bg rounded-xl shadow-soft hover:scale-[1.02] transition-all">
                        <h4 class="text-lg font-semibold text-sky-primary">CQ Khải – “Bug Hunter” 🐞🔫</h4>
                        <p class="mt-2 text-sky-text">Chuyên gia săn bug cấp S, không lỗi nào thoát khỏi mắt diều hâu.</p>
                    </div>
                    <div class="p-6 bg-sky-bg rounded-xl shadow-soft hover:scale-[1.02] transition-all">
                        <h4 class="text-lg font-semibold text-sky-primary">LH Dũng – “Pixel Witch” 🧙‍♀️</h4>
                        <p class="mt-2 text-sky-text">Thiết kế giao diện mượt như nhung, biến ý tưởng thành hình ảnh sống động.</p>
                    </div>
                    <div class="p-6 bg-sky-bg rounded-xl shadow-soft hover:scale-[1.02] transition-all">
                        <h4 class="text-lg font-semibold text-sky-primary">TD Bách – “Data Whisperer” 📊</h4>
                        <p class="mt-2 text-sky-text">Người thì thầm với dữ liệu, lo phần logic và xử lý phức tạp phía sau.</p>
                    </div>
                </div>
            </div>
            <div class="mt-12 text-center text-sky-text leading-relaxed max-w-3xl mx-auto">
                <p>
                    Chúng em xin chân thành cảm ơn <strong>Thầy Nguyễn Đức Mận</strong> – người đã luôn hướng dẫn tận tình như một "Debugger sống", cùng các anh chị công ty <strong>Kaopiz</strong> – những người đã hỗ trợ và chia sẻ kinh nghiệm quý báu, giúp dự án SkyStudy đi từ ý tưởng đến sản phẩm thực tế.
                </p>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section id="download" class="py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in">
            <h2 class="text-3xl sm:text-4xl font-bold text-sky-primary text-center">Tải xuống công cụ</h2>
            <div class="mt-12 grid grid-cols-1 gap-8 max-w-xl mx-auto">
                <div class="p-8 bg-sky-white rounded-2xl shadow-soft flex items-center hover:scale-[1.02] transition-all">
                    <div class="h-16 w-16 bg-sky-bg flex items-center justify-center rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8 stroke-sky-primary">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                    </div>
                    <div class="ml-6">
                        <h3 class="text-xl font-semibold text-sky-primary">Công cụ học tập</h3>
                        <p class="mt-2 text-sky-text text-base">Tải xuống ứng dụng SkyStudy để bắt đầu hành trình học tiếng Anh vui nhộn.</p>
                            <a href="https://github.com/CaptainZung/SkyStudy_Release/releases/download/v1.0.0/app-release.apk" download class="mt-4 inline-block btn-primary px-6 py-2 text-sky-white rounded-lg font-semibold">Tải ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-10 bg-sky-primary text-sky-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center space-x-6 mb-6">
                <a href="#" class="hover:text-sky-accent transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124-4.09-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 14.307-14.416 0-.219-.006-.437-.019-.655.981-.689 1.818-1.541 2.482-2.524z"/>
                    </svg>
                </a>
                <a href="#" class="hover:text-sky-accent transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.04c-5.523 0-10 4.477-10 10 0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54v-2.891h2.54v-2.203c0-2.506 1.492-3.891 3.777-3.891 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562v1.877h2.773l-.443 2.891h-2.33v6.988c4.781-.75 8.438-4.887 8.438-9.879 0-5.523-4.477-10-10-10z"/>
                    </svg>
                </a>
            </div>
            <p class="text-sm">© 2025 SkyStudy. Mọi quyền được bảo lưu.</p>
        </div>
    </footer>

    <!-- JavaScript for smooth scrolling and carousel -->
    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Carousel functionality
        const items = document.querySelectorAll('.carousel-item');
        const dots = document.querySelectorAll('.dot');
        let currentIndex = 0;

        function showSlide(index) {
            items.forEach((item, i) => {
                item.classList.toggle('active', i === index);
                dots[i].classList.toggle('bg-sky-primary', i === index);
                dots[i].classList.toggle('bg-gray-300', i !== index);
            });
        }

        document.getElementById('prevBtn').addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + items.length) % items.length;
            showSlide(currentIndex);
        });

        document.getElementById('nextBtn').addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % items.length;
            showSlide(currentIndex);
        });

        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                currentIndex = parseInt(dot.getAttribute('data-index'));
                showSlide(currentIndex);
            });
        });

        // Auto slide every 4 seconds
        setInterval(() => {
            currentIndex = (currentIndex + 1) % items.length;
            showSlide(currentIndex);
        }, 4000);
    </script>
</body>
</html>
