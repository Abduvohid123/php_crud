document.addEventListener('DOMContentLoaded', () => {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const dashboardContainer = document.querySelector('.dashboard-container');
    const sidebar = document.getElementById('sidebar');
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    const contentSections = document.querySelectorAll('.content-section');

    // Student Section Elements
    const createStudentBtn = document.getElementById('create-student-btn');
    const studentModal = document.getElementById('student-modal');
    const closeModalBtns = document.querySelectorAll('.close-modal-btn');
    const studentForm = document.getElementById('student-form');
    const modalTitle = document.getElementById('modal-title');
    const studentsTableBody = document.querySelector('#students-table tbody');
    const studentSearchName = document.getElementById('student-search-name');
    const studentSearchGroup = document.getElementById('student-search-group');

    let editingStudentId = null; // To keep track of which student is being edited

    // Dummy Student Data
    let students = [
        { id: 1, name: "Ali Valiyev", phone: "+998901234567", group: "Guruh A", password: "password1" },
        { id: 2, name: "Dilnoza Karimova", phone: "+998917654321", group: "Guruh B", password: "password2" },
        { id: 3, name: "Jasur Saidov", phone: "+998939876543", group: "Guruh A", password: "password3" },
        { id: 4, name: "Nargiza Rustamova", phone: "+998941239876", group: "Guruh C", password: "password4" },
        { id: 5, name: "Bekzod Olimov", phone: "+998995678901", group: "Guruh B", password: "password5" },
    ];

    // --- Sidebar Toggle Logic ---
    const isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isSidebarCollapsed) {
        dashboardContainer.classList.add('collapsed');
    }

    sidebarToggle.addEventListener('click', () => {
        dashboardContainer.classList.toggle('collapsed');
        if (window.innerWidth <= 768) {
            dashboardContainer.classList.toggle('sidebar-open');
        }
        const currentState = dashboardContainer.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', currentState);
    });

    document.addEventListener('click', (event) => {
        if (window.innerWidth <= 768 && dashboardContainer.classList.contains('sidebar-open')) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = sidebarToggle.contains(event.target);
            if (!isClickInsideSidebar && !isClickOnToggle) {
                dashboardContainer.classList.remove('sidebar-open');
            }
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            dashboardContainer.classList.remove('sidebar-open');
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                dashboardContainer.classList.add('collapsed');
            } else {
                dashboardContainer.classList.remove('collapsed');
            }
        } else {
            dashboardContainer.classList.remove('collapsed');
        }
    });

    // --- Sidebar Navigation Logic ---
    sidebarLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetSectionId = link.dataset.section;

            // Remove active class from all links
            sidebarLinks.forEach(l => l.classList.remove('active'));
            // Add active class to clicked link
            link.classList.add('active');

            // Hide all content sections
            contentSections.forEach(section => section.classList.add('hidden'));
            // Show the target section
            document.getElementById(targetSectionId).classList.remove('hidden');

            // If it's the students section, render the table
            if (targetSectionId === 'students-section') {
                renderStudentsTable();
            }

            // Close sidebar on mobile after navigation
            if (window.innerWidth <= 768) {
                dashboardContainer.classList.remove('sidebar-open');
            }
        });
    });

    // --- Student Table Functions ---
    function renderStudentsTable(filteredStudents = students) {
        studentsTableBody.innerHTML = ''; // Clear existing rows
        if (filteredStudents.length === 0) {
            studentsTableBody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 20px;">Hech qanday talaba topilmadi.</td></tr>';
            return;
        }

        // filteredStudents.forEach(student => {
        //     const row = studentsTableBody.insertRow();
        //     row.innerHTML = `
        //       <td>${student.id}</td>
        //       <td>${student.name}</td>
        //       <td>${student.phone}</td>
        //       <td>${student.group}</td>
        //       <td>
        //           <div class="action-buttons">
        //               <button class="action-button edit" data-id="${student.id}">
        //                   <i class="ri-pencil-line"></i> Tahrirlash
        //               </button>
        //               <button class="action-button delete" data-id="${student.id}">
        //                   <i class="ri-delete-bin-line"></i> O'chirish
        //               </button>
        //           </div>
        //       </td>
        //   `;
        // });
    }

    function filterStudentsTable() {
        const nameQuery = studentSearchName.value.toLowerCase();
        const groupQuery = studentSearchGroup.value.toLowerCase();

        const filtered = students.filter(student => {
            const matchesName = student.name.toLowerCase().includes(nameQuery);
            const matchesGroup = student.group.toLowerCase().includes(groupQuery);
            return matchesName && matchesGroup;
        });
        renderStudentsTable(filtered);
    }

    // --- Side Modal Functions ---
    function openSideModal(mode = 'create', studentData = null) {
        studentForm.reset(); // Clear form fields
        editingStudentId = null; // Reset editing state

        if (mode === 'create') {
            modalTitle.textContent = 'Yangi talaba yaratish';
        } else if (mode === 'edit' && studentData) {
            modalTitle.textContent = 'Talabani tahrirlash';
            document.getElementById('student-name').value = studentData.name;
            document.getElementById('student-phone').value = studentData.phone;
            document.getElementById('student-group').value = studentData.group;
            // Password field is usually not pre-filled for security
            document.getElementById('student-password').value = '';
            editingStudentId = studentData.id;
        }
        studentModal.classList.add('open');
    }

    function closeSideModal() {
        studentModal.classList.remove('open');
    }

    // --- Event Listeners ---
    createStudentBtn.addEventListener('click', () => openSideModal('create'));
    closeModalBtns.forEach(btn => btn.addEventListener('click', closeSideModal));

    studentForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(studentForm);
        const newStudent = {
            name: formData.get('name'),
            phone: formData.get('phone'),
            group: formData.get('group'),
            password: formData.get('password'),
        };

        if (editingStudentId) {
            // Edit existing student
            students = students.map(s => s.id === editingStudentId ? { ...s, ...newStudent } : s);
            console.log('Talaba tahrirlandi:', newStudent);
        } else {
            // Create new student
            newStudent.id = students.length > 0 ? Math.max(...students.map(s => s.id)) + 1 : 1;
            students.push(newStudent);
            console.log('Yangi talaba yaratildi:', newStudent);
        }

        renderStudentsTable(); // Re-render table with updated data
        closeSideModal();
    });

    // Event delegation for Edit and Delete buttons
    studentsTableBody.addEventListener('click', (e) => {
        const target = e.target.closest('.action-button');
        if (!target) return;

        const studentId = parseInt(target.dataset.id);
        const student = students.find(s => s.id === studentId);

        if (target.classList.contains('edit')) {
            if (student) {
                openSideModal('edit', student);
            }
        } else if (target.classList.contains('delete')) {
            if (confirm(`Haqiqatan ham ${student.name} ismli talabani o'chirmoqchimisiz?`)) {
                students = students.filter(s => s.id !== studentId);
                renderStudentsTable();
                console.log('Talaba o\'chirildi:', studentId);
            }
        }
    });

    // Search input event listeners
    studentSearchName.addEventListener('input', filterStudentsTable);
    studentSearchGroup.addEventListener('input', filterStudentsTable);

    // Initial render of the dashboard section
    // document.getElementById('dashboard-section').classList.remove('hidden');
    // document.querySelector('.sidebar-link[data-section="dashboard-section"]').classList.add('active');
});
