<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pendidikan Yayasan El-Jufa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body { font-family: 'Segoe UI', sans-serif; }
  </style>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const schools = [
        {
          name: "Taman Kanak-Kanak (TK)",
          icon: "fa-seedling",
          title: "Pendidikan Anak Usia Dini",
          desc: "Kami memberikan pendidikan karakter, sosial, dan dasar akademik bagi anak-anak usia dini melalui pendekatan bermain sambil belajar.",
          imageSrc: "/hero1.jpg",
        },
        {
          name: "Sekolah Dasar (SD)",
          icon: "fa-school",
          title: "Pendidikan Dasar",
          desc: "Membangun fondasi ilmu pengetahuan, akhlak, dan keterampilan dasar yang dibutuhkan siswa untuk melanjutkan ke jenjang lebih tinggi.",
          imageSrc:"/hero2.jpg",
        },
        {
          name: "Pesantren",
          icon: "fa-mosque",
          title: "Pendidikan Agama & Kemandirian",
          desc: "Pendidikan agama Islam yang mendalam disertai pembinaan keterampilan hidup dan kewirausahaan bagi santri di lingkungan pesantren.",
          imageSrc: "/hero3.jpg",
        }
      ];

      let selected = 0;

      const updateContent = () => {
        const school = schools[selected];
        document.getElementById("desc").textContent = school.desc;
        document.getElementById("name-title").innerHTML = `<i class="fas ${school.icon} text-yellow-400 mr-2"></i> ${school.name} - ${school.title}`;
        document.getElementById("image").src = school.imageSrc;

        document.querySelectorAll(".tab-button").forEach((btn, idx) => {
          if (idx === selected) {
            btn.classList.add("bg-[#003f87]", "text-white");
            btn.classList.remove("bg-gray-100", "text-gray-700");
          } else {
            btn.classList.add("bg-gray-100", "text-gray-700");
            btn.classList.remove("bg-[#003f87]", "text-white");
          }
        });
      };

      document.querySelectorAll(".tab-button").forEach((btn, idx) => {
        btn.addEventListener("click", () => {
          selected = idx;
          updateContent();
        });
      });

      document.getElementById("prev-btn").addEventListener("click", () => {
        selected = (selected - 1 + schools.length) % schools.length;
        updateContent();
      });

      document.getElementById("next-btn").addEventListener("click", () => {
        selected = (selected + 1) % schools.length;
        updateContent();
      });

      updateContent();
    });
  </script>
</head>
<body class="bg-white text-gray-800">

<section id="schools" class="py-20 bg-teal-800 text-white px-4">
  <div class="max-w-5xl mx-auto">
    <h2 class="text-4xl font-extrabold text-center mb-10">Pendidikan di Yayasan El-Jufa</h2>

    <!-- Tabs -->
    <div class="flex flex-wrap justify-center gap-4 mb-10">
      <button class="px-5 py-2 rounded-full font-semibold tab-button transition shadow hover:bg-yellow-500 hover:text-white">TK</button>
      <button class="px-5 py-2 rounded-full font-semibold tab-button transition shadow hover:bg-yellow-500 hover:text-white">SD</button>
      <button class="px-5 py-2 rounded-full font-semibold tab-button transition shadow hover:bg-yellow-500 hover:text-white">Pesantren</button>
    </div>

    <!-- Content Card -->
    <div class="bg-white text-gray-700 rounded-xl shadow-xl flex flex-col md:flex-row items-center p-6 gap-6">
      <div class="flex-1">
        <h3 id="name-title" class="text-2xl font-bold mb-4"></h3>
        <p id="desc" class="text-base leading-relaxed"></p>
      </div>
      <div class="flex-1 text-center">
        <img id="image" src="" alt="Gambar Pendidikan" class="rounded-lg shadow-md h-52 md:h-60 object-cover mx-auto">
      </div>
    </div>

    <!-- Nav Buttons -->
    <div class="flex justify-center mt-8 gap-6">
      <button id="prev-btn" class="p-3 bg-yellow-400 text-white rounded-full shadow-lg hover:bg-yellow-500 transition">
        <i class="fas fa-arrow-left"></i>
      </button>
      <button id="next-btn" class="p-3 bg-yellow-400 text-white rounded-full shadow-lg hover:bg-yellow-500 transition">
        <i class="fas fa-arrow-right"></i>
      </button>
    </div>
  </div>
</section>

</body>
</html>
