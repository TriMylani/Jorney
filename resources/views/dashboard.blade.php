<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LangkahKu - Habit Tracker & Journey Planner</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { height: 6px; width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-800 min-h-screen antialiased flex flex-col" x-data="{ showModalHabit: false }">

    <!-- TOP NAVIGATION BAR -->
    <header class="bg-indigo-700 text-white shadow-lg sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-white/10 p-2 rounded-lg backdrop-blur-md">
                    <i class="fa-solid fa-compass text-2xl text-amber-300"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-xl tracking-wide">LangkahKu</h1>
                    <p class="text-xs text-indigo-200">Journey Planner & Habit Tracker</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="hidden sm:flex items-center space-x-2 bg-indigo-800/60 px-3 py-1.5 rounded-full border border-indigo-500/30 text-xs">
                    <i class="fa-regular fa-calendar-days text-amber-300"></i>
                    <span class="font-medium"><?php echo $namaBulan; ?></span>
                </div>
                <button @click="showModalHabit = true" class="bg-amber-400 hover:bg-amber-300 text-indigo-950 font-bold px-3 py-1.5 rounded-lg text-xs transition flex items-center gap-1.5 shadow cursor-pointer">
                    <i class="fa-solid fa-plus"></i> Tambah Habit
                </button>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT CONTAINER -->
    <main class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 flex-1 space-y-8">

        <!-- RINGKASAN STATISTIK -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tugas Hari Ini</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?php echo count($todosHarian); ?></h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-fire"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Aktif Habit</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?php echo count($habits); ?></h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Hari Dalam Bulan</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?php echo $jumlahHari; ?> Hari</h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status Sistem</p>
                    <h3 class="text-2xl font-bold text-emerald-600">Aktif</h3>
                </div>
            </div>
        </section>

        <!-- TWO COLUMN LAYOUT -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- KIRI: TO-DO HARIAN -->
            <section class="lg:col-span-4 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden" x-data="todoApp()">
                <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-circle-dot text-indigo-600"></i>
                        <h2 class="font-bold text-slate-800 text-base">Fokus Hari Ini</h2>
                    </div>
                    <span class="text-xs bg-indigo-100 text-indigo-700 px-2.5 py-1 rounded-full font-semibold">To-Do</span>
                </div>

                <div class="p-5 space-y-3 max-h-[480px] overflow-y-auto custom-scrollbar">
                    <?php if (count($todosHarian) > 0): ?>
                        <?php foreach ($todosHarian as$todo): ?>
                            <div x-data="todoItem(<?php echo $todo->id; ?>, '<?php echo addslashes($todo->judul); ?>', <?php echo$todo->is_selesai ? 'true' : 'false'; ?>)" 
                                 class="group flex items-center justify-between p-3 rounded-xl border border-slate-200/70 hover:border-indigo-300 hover:shadow-sm transition bg-white">
                                
                                <div class="flex items-center space-x-3 flex-1 min-w-0">
                                    <input type="checkbox" x-model="isSelesai" @change="toggleStatus()" 
                                           class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500 cursor-pointer">

                                    <template x-if="!isEditing">
                                        <span @click="isEditing = true" 
                                              :class="{ 'line-through text-slate-400': isSelesai, 'text-slate-700': !isSelesai }"
                                              class="text-sm font-medium truncate cursor-pointer hover:text-indigo-600 transition"
                                              x-text="judul"></span>
                                    </template>

                                    <template x-if="isEditing">
                                        <input type="text" x-model="judul" 
                                               @keydown.enter="simpanJudul()"
                                               @blur="simpanJudul()"
                                               class="w-full text-sm border-b-2 border-indigo-600 outline-none px-1 bg-transparent font-medium">
                                    </template>
                                </div>

                                <button @click="hapusTodo()" class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-red-500 text-xs p-1 transition cursor-pointer">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-10">
                            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-lg">
                                <i class="fa-solid fa-clipboard-check"></i>
                            </div>
                            <p class="text-sm text-slate-400 font-medium">Belum ada tugas hari ini.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Input Tambah Cepat To-Do -->
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    <div class="flex items-center bg-white border border-slate-200 rounded-xl px-3 py-2 focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 transition">
                        <i class="fa-solid fa-plus text-slate-400 mr-2 text-xs"></i>
                        <input type="text" x-model="inputBaru" @keydown.enter="tambahTodo()" 
                               placeholder="Ketik tugas baru lalu tekan Enter..." 
                               class="w-full text-xs outline-none bg-transparent placeholder-slate-400">
                    </div>
                </div>
            </section>

            <!-- KANAN: MATRIKS KEBIASAAN BULANAN -->
            <section class="lg:col-span-8 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-slate-800 text-base">Matriks Kebiasaan Bulanan</h2>
                        <p class="text-xs text-slate-500">Klik tanggal untuk mencatat ketercapaian kebiasaan</p>
                    </div>
                    <div class="flex items-center space-x-2 text-xs text-slate-500">
                        <span class="inline-block w-3 h-3 rounded bg-emerald-500"></span> <span>Selesai</span>
                        <span class="inline-block w-3 h-3 rounded bg-slate-100 border border-slate-300 ml-2"></span> <span>Belum</span>
                    </div>
                </div>

                <div class="p-5 overflow-x-auto custom-scrollbar">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="text-left py-3 px-3 text-xs font-bold text-slate-500 uppercase tracking-wider sticky left-0 bg-white z-10 shadow-sm border-b min-w-[160px]">
                                    Kebiasaan
                                </th>
                                <?php for ($h = 1; $h <= $jumlahHari; $h++): ?>
                                    <th class="py-2 px-1 text-center text-[11px] font-semibold text-slate-500 border-b min-w-[28px]">
                                        <?php echo $h; ?>
                                    </th>
                                <?php endfor; ?>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            <?php if (count($habits) > 0): ?>
                                <?php foreach ($habits as$habit): ?>
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="text-left font-semibold py-3 px-3 text-slate-700 sticky left-0 bg-white z-10 shadow-sm whitespace-nowrap">
                                            <div class="flex items-center space-x-2">
                                                <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                                <span><?php echo $habit->nama_kebiasaan; ?></span>
                                            </div>
                                        </td>
                                        
                                        <?php for ($h = 1; $h <= $jumlahHari; $h++): ?>
                                            <td class="py-2 px-1 text-center" x-data="{ checked: false }">
                                                <button @click="checked = !checked" 
                                                        :class="checked ? 'bg-emerald-500 border-emerald-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-indigo-100 border-slate-200 text-transparent'"
                                                        class="w-5 h-5 mx-auto rounded border transition flex items-center justify-center text-[10px] focus:outline-none cursor-pointer">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            </td>
                                        <?php endfor; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="<?php echo $jumlahHari + 1; ?>" class="py-12 text-center text-slate-400">
                                        <i class="fa-solid fa-seedling text-3xl mb-2 text-slate-300"></i>
                                        <p class="font-medium text-sm">Belum ada kebiasaan yang dibuat.</p>
                                        <p class="text-xs text-slate-400 mt-1">Klik tombol "+ Tambah Habit" di atas untuk membuat kebiasaan baru.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>

    <!-- MODAL FORM TAMBAH HABIT -->
    <div x-show="showModalHabit" x-cloak class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div @click.away="showModalHabit = false" class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 space-y-5" x-data="habitForm()">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-bold text-lg text-slate-800">Tambah Kebiasaan Baru</h3>
                <button @click="showModalHabit = false" class="text-slate-400 hover:text-slate-600 text-sm">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Nama Kebiasaan</label>
                    <input type="text" x-model="namaKebiasaan" @keydown.enter="simpanHabit()" placeholder="Contoh: Olahraga 30 Menit, Baca Buku..." 
                           class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                </div>
            </div>

            <div class="flex justify-end space-x-2 pt-2">
                <button @click="showModalHabit = false" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-100 transition">Batal</button>
                <button @click="simpanHabit()" class="px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white transition shadow">Simpan Habit</button>
            </div>
        </div>
    </div>

    <!-- ALPINE JS LOGIC -->
    <script>
        function todoItem(id, initialJudul, initialSelesai) {
            return {
                id: id,
                judul: initialJudul,
                isSelesai: initialSelesai,
                isEditing: false,
                simpanJudul() {
                    this.isEditing = false;
                    fetch(`/api/todos/${this.id}`, {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>' },
                        body: JSON.stringify({ judul: this.judul })
                    });
                },
                toggleStatus() {
                    fetch(`/api/todos/${this.id}`, {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>' },
                        body: JSON.stringify({ is_selesai: this.isSelesai })
                    });
                },
                hapusTodo() {
                    if (confirm('Hapus tugas ini?')) {
                        fetch(`/api/todos/${this.id}`, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>' }
                        }).then(() => location.reload());
                    }
                }
            }
        }

        function todoApp() {
            return {
                inputBaru: '',
                tambahTodo() {
                    if (!this.inputBaru.trim()) return;
                    fetch('/api/todos', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>' },
                        body: JSON.stringify({ judul: this.inputBaru })
                    }).then(() => location.reload());
                }
            }
        }

        function habitForm() {
            return {
                namaKebiasaan: '',
                simpanHabit() {
                    if (!this.namaKebiasaan.trim()) return;
                    fetch('/api/habits', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>' },
                        body: JSON.stringify({ nama_kebiasaan: this.namaKebiasaan })
                    }).then(() => location.reload());
                }
            }
        }
    </script>
</body>
</html>