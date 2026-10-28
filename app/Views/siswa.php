<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa XI RPL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    <div
        x-data="{ activeModal: null }"
        @open-siswa-modal.window="activeModal = $event.detail"
        @close-siswa-modal.window="activeModal = null"
        @keydown.escape.window="activeModal = null"
    >
        <nav class="border-b border-gray-200 bg-white">
            <div class="mx-auto flex h-16 max-w-7xl items-center px-4 sm:px-6 lg:px-8">
                <a href="#" class="flex items-center gap-3 text-slate-800 no-underline">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m18 0v-2a4 4 0 0 0-3-3.87M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8-7.87a4 4 0 0 1 0 7.75" />
                        </svg>
                    </span>
                    <span class="text-sm font-semibold tracking-tight">Data Siswa</span>
                </a>
            </div>
        </nav>

        <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="mb-7">
                <p class="mb-2 text-sm font-medium text-blue-600">Manajemen akademik</p>
                <h1 class="text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl">Daftar Siswa Terdaftar</h1>
                <p class="mt-2 text-sm text-slate-500">Kelola informasi siswa dan data kelas dalam satu tempat.</p>
            </div>

            <div id="tableMessage" class="fixed right-4 top-20 z-[80] hidden max-w-md rounded-xl border border-red-200 bg-white px-4 py-3 text-sm text-red-700 shadow-lg sm:right-6" role="alert"></div>

            <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="flex flex-col gap-4 border-b border-gray-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">Data siswa</h2>
                        <p class="mt-1 text-sm text-slate-500">Lihat, cari, dan perbarui data yang terdaftar.</p>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <label class="relative block sm:w-72">
                            <span class="sr-only">Cari siswa</span>
                            <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <circle cx="11" cy="11" r="7" />
                                <path stroke-linecap="round" d="m20 20-4-4" />
                            </svg>
                            <input
                                type="search"
                                id="searchSiswa"
                                class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-9 pr-3 text-sm text-slate-900 outline-none placeholder:text-slate-400 transition focus:border-transparent focus:ring-2 focus:ring-blue-500"
                                placeholder="Cari NIS, nama, atau kelas..."
                                aria-label="Cari data siswa berdasarkan NIS, nama, atau kelas"
                            >
                        </label>
                        <button
                            type="button"
                            @click="activeModal = 'add'"
                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                            </svg>
                            Tambah siswa
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="w-16 px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">No</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">NIS</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nama</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kelas</th>
                                <th scope="col" class="w-28 px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php if (empty($siswa)): ?>
                                <tr data-empty-row>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">Belum ada data siswa.</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; ?>
                                <?php foreach ($siswa as $row): ?>
                                <tr data-siswa-row data-siswa-id="<?= esc($row['id']) ?>" class="transition-colors hover:bg-slate-50">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500"><?= $no++ ?></td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-700"><?= esc($row['nis'] ?? '') ?></td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900"><?= esc($row['nama'] ?? '') ?></td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        <span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700"><?= esc($row['kelas'] ?? '') ?></span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <div class="inline-flex items-center gap-1">
                                            <button type="button" data-edit-siswa title="Edit siswa" aria-label="Edit siswa" class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.86 4.49 2.65 2.65M4 20l4.25-.85L19.2 8.2a1.88 1.88 0 0 0-2.65-2.65L5.6 16.5 4 20Z" />
                                                </svg>
                                            </button>
                                            <form method="post" action="<?= esc(parse_url(site_url('home/hapus/' . $row['id']), PHP_URL_PATH)) ?>" data-delete-form>
                                                <button type="submit" title="Hapus siswa" aria-label="Hapus siswa" class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-red-50 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M10 11v6m4-6v6M5.5 7l.8 13h11.4l.8-13M9 7V4h6v3" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <tr data-no-results hidden>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">Data siswa tidak ditemukan.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Navigasi halaman data siswa" class="border-t border-gray-200 px-5 py-4 sm:px-6">
                    <ul id="pagination" class="flex items-center justify-center gap-1"></ul>
                </nav>
            </section>
        </main>

        <div
            x-cloak
            x-show="activeModal === 'edit'"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-gray-900/50 p-4 backdrop-blur-sm"
            role="dialog"
            aria-modal="true"
            aria-labelledby="modalEditLabel"
            @click.self="activeModal = null"
        >
            <div
                x-show="activeModal === 'edit'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="translate-y-2 scale-95 opacity-0"
                x-transition:enter-end="translate-y-0 scale-100 opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="translate-y-0 scale-100 opacity-100"
                x-transition:leave-end="translate-y-2 scale-95 opacity-0"
                class="my-auto w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl"
            >
                <form action="<?= esc(parse_url(site_url('home/edit'), PHP_URL_PATH)) ?>" method="post" id="formEdit">
                    <div class="mb-6 flex items-start justify-between gap-4">
                        <div>
                            <h2 id="modalEditLabel" class="text-lg font-semibold tracking-tight text-slate-900">Edit data siswa</h2>
                            <p class="mt-1 text-sm text-slate-500">Perbarui informasi siswa di bawah ini.</p>
                        </div>
                        <button type="button" @click="activeModal = null" aria-label="Tutup modal" class="rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" />
                            </svg>
                        </button>
                    </div>
                    <input type="hidden" name="id" id="editId">
                    <div class="space-y-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700" for="editNis">NIS</label>
                            <input type="text" name="nis" id="editNis" required class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-transparent focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700" for="editNama">Nama Lengkap</label>
                            <input type="text" name="nama" id="editNama" required class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-transparent focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700" for="editKelas">Kelas</label>
                            <div class="relative">
                                <select name="kelas" id="editKelas" required class="block w-full appearance-none rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 pr-10 text-sm text-slate-900 outline-none transition focus:border-transparent focus:ring-2 focus:ring-blue-500">
                                    <option value="" disabled selected>Pilih Kelas</option>
                                    <option value="X RPL">X RPL</option>
                                    <option value="XI RPL">XI RPL</option>
                                    <option value="XII RPL">XII RPL</option>
                                    <option value="X BC">X BC</option>
                                    <option value="XI BC">XI BC</option>
                                    <option value="XII BC">XII BC</option>
                                    <option value="X MM">X MM</option>
                                    <option value="XI MM">XI MM</option>
                                    <option value="XII MM">XII MM</option>
                                </select>
                                <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m7 10 5 5 5-5" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <button type="button" @click="activeModal = null" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Batal</button>
                        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Simpan perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <div
            x-cloak
            x-show="activeModal === 'add'"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-gray-900/50 p-4 backdrop-blur-sm"
            role="dialog"
            aria-modal="true"
            aria-labelledby="modalTambahLabel"
            @click.self="activeModal = null"
        >
            <div
                x-show="activeModal === 'add'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="translate-y-2 scale-95 opacity-0"
                x-transition:enter-end="translate-y-0 scale-100 opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="translate-y-0 scale-100 opacity-100"
                x-transition:leave-end="translate-y-2 scale-95 opacity-0"
                class="my-auto w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl"
            >
                <form action="<?= esc(parse_url(site_url('home/tambah'), PHP_URL_PATH)) ?>" method="post" id="formTambah">
                    <div class="mb-6 flex items-start justify-between gap-4">
                        <div>
                            <h2 id="modalTambahLabel" class="text-lg font-semibold tracking-tight text-slate-900">Tambah data siswa</h2>
                            <p class="mt-1 text-sm text-slate-500">Lengkapi informasi siswa baru untuk didaftarkan.</p>
                        </div>
                        <button type="button" @click="activeModal = null" aria-label="Tutup modal" class="rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" />
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700" for="tambahNis">NIS</label>
                            <input type="text" name="nis" id="tambahNis" required class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-transparent focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700" for="tambahNama">Nama Lengkap</label>
                            <input type="text" name="nama" id="tambahNama" required class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-transparent focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700" for="tambahKelas">Kelas</label>
                            <div class="relative">
                                <select name="kelas" id="tambahKelas" required class="block w-full appearance-none rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 pr-10 text-sm text-slate-900 outline-none transition focus:border-transparent focus:ring-2 focus:ring-blue-500">
                                    <option value="" disabled selected>Pilih Kelas</option>
                                    <option value="X RPL">X RPL</option>
                                    <option value="XI RPL">XI RPL</option>
                                    <option value="XII RPL">XII RPL</option>
                                    <option value="X BC">X BC</option>
                                    <option value="XI BC">XI BC</option>
                                    <option value="XII BC">XII BC</option>
                                    <option value="X MM">X MM</option>
                                    <option value="XI MM">XI MM</option>
                                    <option value="XII MM">XII MM</option>
                                </select>
                                <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m7 10 5 5 5-5" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <button type="button" @click="activeModal = null" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Batal</button>
                        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const tableBody = document.querySelector('table tbody');
        const tableMessage = document.getElementById('tableMessage');
        const pagination = document.getElementById('pagination');
        const searchInput = document.getElementById('searchSiswa');
        const pageSize = 7;
        let currentPage = 1;

        function showMessage(message) {
            tableMessage.textContent = message;
            tableMessage.classList.remove('hidden');
        }

        function clearMessage() {
            tableMessage.textContent = '';
            tableMessage.classList.add('hidden');
        }

        function closeModal() {
            window.dispatchEvent(new CustomEvent('close-siswa-modal'));
        }

        function updateRowNumbers() {
            tableBody.querySelectorAll('tr[data-siswa-row] td:first-child').forEach((cell, index) => {
                cell.textContent = index + 1;
            });
        }

        function renderPagination() {
            const rows = Array.from(tableBody.querySelectorAll('tr[data-siswa-row]'));
            const searchTerm = searchInput.value.trim().toLowerCase();
            const filteredRows = rows.filter((row) => {
                const searchableValues = [row.cells[1].textContent, row.cells[2].textContent, row.cells[3].textContent];
                return searchableValues.some((value) => value.toLowerCase().includes(searchTerm));
            });
            const pageCount = Math.ceil(filteredRows.length / pageSize);
            currentPage = Math.min(Math.max(currentPage, 1), Math.max(pageCount, 1));
            const visibleRows = new Set(filteredRows.slice((currentPage - 1) * pageSize, currentPage * pageSize));

            rows.forEach((row) => {
                row.hidden = !visibleRows.has(row);
            });
            const noResultsRow = tableBody.querySelector('[data-no-results]');
            noResultsRow.hidden = rows.length === 0 || filteredRows.length > 0;

            pagination.replaceChildren();
            const paginationNav = pagination.closest('nav');
            if (pageCount <= 1) {
                paginationNav.classList.add('hidden');
                return;
            }

            paginationNav.classList.remove('hidden');

            const addPageButton = (label, page, { active = false, disabled = false, ariaLabel = label } = {}) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = label;
                button.setAttribute('aria-label', ariaLabel);
                button.className = 'rounded-lg px-3 py-2 text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1';
                if (active) {
                    button.setAttribute('aria-current', 'page');
                    button.classList.add('bg-blue-600', 'text-white');
                } else if (disabled) {
                    button.disabled = true;
                    button.classList.add('cursor-not-allowed', 'text-slate-300');
                } else {
                    button.classList.add('text-slate-600', 'hover:bg-slate-100');
                    button.dataset.page = page;
                }

                pagination.appendChild(button);
            };

            addPageButton('Sebelumnya', currentPage - 1, {
                disabled: currentPage === 1,
                ariaLabel: 'Halaman sebelumnya'
            });

            for (let page = 1; page <= pageCount; page++) {
                addPageButton(String(page), page, { active: page === currentPage, ariaLabel: `Halaman ${page}` });
            }

            addPageButton('Berikutnya', currentPage + 1, {
                disabled: currentPage === pageCount,
                ariaLabel: 'Halaman berikutnya'
            });
        }

        function createActionCell(row) {
            const actionCell = document.createElement('td');
            actionCell.className = 'whitespace-nowrap px-6 py-4 text-right';

            const actions = document.createElement('div');
            actions.className = 'inline-flex items-center gap-1';

            const editButton = document.createElement('button');
            editButton.type = 'button';
            editButton.dataset.editSiswa = '';
            editButton.title = 'Edit siswa';
            editButton.setAttribute('aria-label', 'Edit siswa');
            editButton.className = 'inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500';
            editButton.innerHTML = '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m16.86 4.49 2.65 2.65M4 20l4.25-.85L19.2 8.2a1.88 1.88 0 0 0-2.65-2.65L5.6 16.5 4 20Z" /></svg>';
            actions.appendChild(editButton);

            const form = document.createElement('form');
            form.method = 'post';
            form.action = <?= json_encode(parse_url(site_url('home/hapus/'), PHP_URL_PATH)) ?> + encodeURIComponent(row.id);
            form.dataset.deleteForm = '';

            const deleteButton = document.createElement('button');
            deleteButton.type = 'submit';
            deleteButton.title = 'Hapus siswa';
            deleteButton.setAttribute('aria-label', 'Hapus siswa');
            deleteButton.className = 'inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-red-50 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500';
            deleteButton.innerHTML = '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M10 11v6m4-6v6M5.5 7l.8 13h11.4l.8-13M9 7V4h6v3" /></svg>';
            form.appendChild(deleteButton);
            actions.appendChild(form);
            actionCell.appendChild(actions);
            row.appendChild(actionCell);
        }

        function renderSiswa(siswa) {
            const emptyRow = tableBody.querySelector('[data-empty-row]');
            if (emptyRow) {
                emptyRow.remove();
            }

            const row = document.createElement('tr');
            row.dataset.siswaRow = '';
            row.dataset.siswaId = siswa.id;
            row.className = 'transition-colors hover:bg-slate-50';

            const numberCell = document.createElement('td');
            numberCell.className = 'whitespace-nowrap px-6 py-4 text-sm text-slate-500';
            row.appendChild(numberCell);

            const nisCell = document.createElement('td');
            nisCell.className = 'whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-700';
            nisCell.textContent = siswa.nis ?? '';
            row.appendChild(nisCell);

            const nameCell = document.createElement('td');
            nameCell.className = 'whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900';
            nameCell.textContent = siswa.nama ?? '';
            row.appendChild(nameCell);

            const classCell = document.createElement('td');
            classCell.className = 'whitespace-nowrap px-6 py-4 text-sm';
            const classBadge = document.createElement('span');
            classBadge.className = 'inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700';
            classBadge.textContent = siswa.kelas ?? '';
            classCell.appendChild(classBadge);
            row.appendChild(classCell);

            createActionCell(row);
            tableBody.appendChild(row);
            updateRowNumbers();
            renderPagination();
        }

        function showEmptyRow() {
            if (tableBody.querySelectorAll('tr[data-siswa-row]').length === 0) {
                const row = document.createElement('tr');
                row.dataset.emptyRow = '';
                const cell = document.createElement('td');
                cell.colSpan = 5;
                cell.className = 'px-6 py-12 text-center text-sm text-slate-500';
                cell.textContent = 'Belum ada data siswa.';
                row.appendChild(cell);
                tableBody.appendChild(row);
            }
        }

        async function sendForm(form) {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const responseText = await response.text();
            let result;

            try {
                result = JSON.parse(responseText);
            } catch {
                const destination = response.redirected ? ` after redirect to ${response.url}` : '';
                throw new Error(`Server returned a non-JSON response (HTTP ${response.status})${destination}.`);
            }

            if (!response.ok || !result.success) {
                throw new Error(result.message || Object.values(result.errors || {}).join(' ') || 'Permintaan gagal diproses.');
            }

            return result;
        }

        document.getElementById('formTambah').addEventListener('submit', async (event) => {
            event.preventDefault();
            const form = event.currentTarget;
            clearMessage();

            try {
                const result = await sendForm(form);
                renderSiswa(result.siswa);
                form.reset();
                closeModal();
            } catch (error) {
                showMessage(error.message);
            }
        });

        pagination.addEventListener('click', (event) => {
            const button = event.target.closest('button[data-page]');
            if (!button) {
                return;
            }

            currentPage = Number(button.dataset.page);
            renderPagination();
        });

        searchInput.addEventListener('input', () => {
            currentPage = 1;
            renderPagination();
        });

        tableBody.addEventListener('click', (event) => {
            const button = event.target.closest('[data-edit-siswa]');
            if (!button) {
                return;
            }

            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');
            document.getElementById('editId').value = row.dataset.siswaId;
            document.getElementById('editNis').value = cells[1].textContent;
            document.getElementById('editNama').value = cells[2].textContent;
            document.getElementById('editKelas').value = cells[3].textContent.trim();
            window.dispatchEvent(new CustomEvent('open-siswa-modal', { detail: 'edit' }));
        });

        document.getElementById('formEdit').addEventListener('submit', async (event) => {
            event.preventDefault();
            const form = event.currentTarget;
            clearMessage();

            try {
                const result = await sendForm(form);
                const row = Array.from(tableBody.querySelectorAll('tr[data-siswa-row]'))
                    .find((candidate) => candidate.dataset.siswaId === String(result.siswa.id));
                if (!row) {
                    throw new Error('Data siswa berhasil diperbarui, tetapi barisnya tidak ditemukan.');
                }

                row.cells[1].textContent = result.siswa.nis;
                row.cells[2].textContent = result.siswa.nama;
                const classBadge = row.cells[3].querySelector('span');
                classBadge.textContent = result.siswa.kelas;
                renderPagination();
                closeModal();
            } catch (error) {
                showMessage(error.message);
            }
        });

        tableBody.addEventListener('submit', async (event) => {
            const form = event.target.closest('[data-delete-form]');
            if (!form) {
                return;
            }

            event.preventDefault();
            if (!confirm('Apakah kamu yakin ingin menghapus data ini?')) {
                return;
            }

            clearMessage();
            try {
                await sendForm(form);
                form.closest('tr').remove();
                updateRowNumbers();
                showEmptyRow();
                renderPagination();
            } catch (error) {
                showMessage(error.message);
            }
        });

        renderPagination();
    </script>
</body>
</html>
