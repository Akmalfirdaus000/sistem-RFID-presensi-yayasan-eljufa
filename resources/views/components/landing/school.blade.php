<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendidikan Yayasan El-Jufa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const schools = [{
                    name: "Taman Kanak-Kanak (TK)",
                    title: "Pendidikan Anak Usia Dini",
                    desc: "Menyediakan pendidikan dasar untuk anak-anak usia dini yang mencakup pembelajaran dasar seperti berhitung, membaca, dan keterampilan sosial.",
                    imageSrc: "https://via.placeholder.com/300x200?text=TK",
                },
                {
                    name: "Sekolah Dasar (SD)",
                    title: "Pendidikan Dasar",
                    desc: "Memberikan pendidikan dasar dengan kurikulum yang terstruktur untuk mengembangkan keterampilan akademis dan sosial anak-anak.",
                    imageSrc: "https://via.placeholder.com/300x200?text=SD",
                },
                {
                    name: "Pesantren",
                    title: "Pendidikan Agama dan Keterampilan",
                    desc: "Pesantren kami menawarkan pendidikan agama Islam yang mendalam serta keterampilan praktis untuk mempersiapkan masa depan yang lebih baik.",
                    imageSrc: "https://via.placeholder.com/300x200?text=Pesantren",
                }
            ];

            let selected = 0;

            const updateContent = () => {
                const school = schools[selected];
                document.getElementById("desc").textContent = school.desc;
                document.getElementById("name-title").textContent = `${school.name} - ${school.title}`;
                document.getElementById("image").src = school.imageSrc;

                document.querySelectorAll(".tab-button").forEach((button, index) => {
                    if (index === selected) {
                        button.classList.add("bg-[#003f87]", "text-white");
                        button.classList.remove("bg-gray-100", "text-gray-700");
                    } else {
                        button.classList.add("bg-gray-100", "text-gray-700");
                        button.classList.remove("bg-[#003f87]", "text-white");
                    }
                });
            };

            document.querySelectorAll(".tab-button").forEach((button, index) => {
                button.addEventListener("click", () => {
                    selected = index;
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

<body class="bg-gray-50 text-yellow-500">

    <section id="schools" class="py-16 px-4 bg-green-700 mb-10">
        <h2 class="text-3xl font-bold text-center mb-8 text-white">Pendidikan Yayasan El-Jufa</h2>

        <!-- Tabs -->
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <button
                class="px-4 py-2 rounded-full font-semibold transition tab-button shadow-md hover:bg-yellow-500 hover:text-white">Taman
                Kanak-Kanak (TK)</button>
            <button
                class="px-4 py-2 rounded-full font-semibold transition tab-button shadow-md hover:bg-yellow-500 hover:text-white">Sekolah
                Dasar (SD)</button>
            <button
                class="px-4 py-2 rounded-full font-semibold transition tab-button shadow-md hover:bg-yellow-500 hover:text-white">Pesantren</button>
        </div>

        <!-- Content -->
        <div
            class="flex flex-col md:flex-row items-center justify-center max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
            <div class="flex-1">
                <h3 id="desc" class="text-xl font-semibold mb-4 text-gray-700"></h3>
                <p id="name-title" class="text-gray-600"></p>
            </div>
            <div class="flex-1 flex justify-center mt-6 md:mt-0 md:ml-6">
                <img id="image" src="" alt="Sekolah Yayasan" class="rounded-lg shadow-lg h-52 w-auto">
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-center gap-6 mt-6">
            <button id="prev-btn"
                class="p-3 bg-yellow-500 text-white rounded-full shadow-lg hover:bg-green-400 transition">←</button>
            <button id="next-btn"
                class="p-3 bg-yellow-500 text-white rounded-full shadow-lg hover:bg-green-400 transition">→</button>
        </div>
    </section>

</body>

</html>
