<?php
include '../database.php';
//echo "<pre>";
$users = $conn->query("SELECT * FROM users order by id desc")->fetch_all(1);

//var_dump($users);
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LMS Admin Panel</title>
  <link rel="stylesheet" href="style.css">
  <!-- Lucide Icons for modern look -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
  <div class="dashboard-container">
      <!-- Navbar -->
      <header class="navbar">
          <div class="navbar-left">
              <button id="sidebar-toggle" aria-label="Toggle Sidebar">
                  <i class="ri-menu-line"></i>
              </button>
              <h1 class="navbar-title">LMS Admin Panel</h1>
          </div>
          <div class="navbar-right">
              <input type="text" placeholder="Qidirish..." class="search-input" aria-label="Search">
              <button class="icon-button" aria-label="Notifications">
                  <i class="ri-notification-line"></i>
              </button>
              <button class="icon-button" aria-label="User Profile">
                  <i class="ri-user-line"></i>
              </button>
          </div>
      </header>

      <!-- Sidebar -->
      <aside class="sidebar" id="sidebar">
          <nav class="sidebar-nav">
              <ul>
                  <li>
                      <a href="#" class="sidebar-link active" data-section="dashboard-section">
                          <i class="ri-dashboard-line"></i>
                          <span>Boshqaruv paneli</span>
                      </a>
                  </li>
                  <li>
                      <a href="#" class="sidebar-link" data-section="students-section">
                          <i class="ri-group-line"></i>
                          <span>Talabalar</span>
                      </a>
                  </li>
                  <li>
                      <a href="#" class="sidebar-link" data-section="groups-section">
                          <i class="ri-book-open-line"></i>
                          <span>Guruhlar</span>
                      </a>
                  </li>
                  <li>
                      <a href="#" class="sidebar-link" data-section="teachers-section">
                          <i class="ri-user-star-line"></i>
                          <span>O'qituvchilar</span>
                      </a>
                  </li>
                  <li>
                      <a href="#" class="sidebar-link" data-section="finance-section">
                          <i class="ri-wallet-line"></i>
                          <span>Moliya</span>
                      </a>
                  </li>
                  <li>
                      <a href="#" class="sidebar-link" data-section="reports-section">
                          <i class="ri-file-chart-line"></i>
                          <span>Hisobotlar</span>
                      </a>
                  </li>
                  <li>
                      <a href="#" class="sidebar-link" data-section="settings-section">
                          <i class="ri-settings-3-line"></i>
                          <span>Sozlamalar</span>
                      </a>
                  </li>
              </ul>
          </nav>
      </aside>

      <!-- Main Content -->
      <main class="main-content" id="main-content">
          <!-- Boshqaruv paneli Section -->
          <section id="dashboard-section" class="content-section hidden">
              <h2>Boshqaruv paneli</h2>
              <p>Bu yerda asosiy ma'lumotlar va statistikalar ko'rsatiladi.</p>
              <div class="card-grid">
                  <div class="card">
                      <h3>Jami Talabalar</h3>
                      <p class="card-value">1200</p>
                  </div>
                  <div class="card">
                      <h3>Jami Guruhlar</h3>
                      <p class="card-value">50</p>
                  </div>
                  <div class="card">
                      <h3>Jami O'qituvchilar</h3>
                      <p class="card-value">30</p>
                  </div>
                  <div class="card">
                      <h3>Faol Kurslar</h3>
                      <p class="card-value">15</p>
                  </div>
              </div>
              <section class="content-section">
                  <h2>So'nggi Faoliyat</h2>
                  <ul>
                      <li>Yangi talaba qo'shildi: Ali Valiyev</li>
                      <li>"Web Dasturlash" guruhi yaratildi</li>
                      <li>O'qituvchi Ahmadjonov dars jadvalini yangiladi</li>
                  </ul>
              </section>
          </section>

          <!-- Talabalar Section -->
          <section id="students-section" class="content-section">
              <h2>Talabalar</h2>
              <div class="control-panel">
                  <div class="search-filters">
                      <input type="text" id="student-search-name" placeholder="Ism bo'yicha qidirish..." class="filter-input" aria-label="Search by name">
                      <input type="text" id="student-search-group" placeholder="Guruh bo'yicha qidirish..." class="filter-input" aria-label="Search by group">
                  </div>
                  <button id="create-student-btn" class="primary-button">
                      <i class="ri-add-line"></i> Talaba yaratish
                  </button>
              </div>

              <div class="table-container">
                  <table class="data-table" id="students-table">
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th>Ism</th>
                              <th>Telefon raqami</th>
                              <th>Guruh</th>
                              <th>Amallar</th>
                          </tr>
                      </thead>
                      <tbody>

                      <?php  foreach ($users as $user) : ?>
                         <tr>
                             <td><?=$user['id']?></td>
                             <td> <?=$user['name']?> </td>
                             <td> <?=$user['mobile_numer']?></td>
                             <td> <?=$user['created_at']?> </td>

                             <td>
                                 <div class="action-buttons">
                                     <a class="action-button edit" href="edit.php?id=<?=$user['id']?>">
                                         <i class="ri-pencil-line"></i> Tahrirlash
                                     </a>
                                     <a class="action-button delete" href="delete.php?id=<?=$user['id']?>">
                                         <i class="ri-delete-bin-line"></i> O'chirish
                                     </a>
                                 </div>
                             </td>

                         </tr>

                      <?php endforeach; ?>
                      </tbody>
                  </table>
              </div>
          </section>

          <!-- Other Sections (initially hidden) -->
          <section id="groups-section" class="content-section hidden">
              <h2>Guruhlar</h2>
              <p>Guruhlar haqidagi ma'lumotlar shu yerda bo'ladi.</p>
          </section>
          <section id="teachers-section" class="content-section hidden">
              <h2>O'qituvchilar</h2>
              <p>O'qituvchilar haqidagi ma'lumotlar shu yerda bo'ladi.</p>
          </section>
          <section id="finance-section" class="content-section hidden">
              <h2>Moliya</h2>
              <p>Moliya hisobotlari shu yerda bo'ladi.</p>
          </section>
          <section id="reports-section" class="content-section hidden">
              <h2>Hisobotlar</h2>
              <p>Hisobotlar shu yerda bo'ladi.</p>
          </section>
          <section id="settings-section" class="content-section hidden">
              <h2>Sozlamalar</h2>
              <p>Tizim sozlamalari shu yerda bo'ladi.</p>
          </section>
      </main>
  </div>

  <!-- Side Modal for Create/Edit Student -->
  <div class="side-modal" id="student-modal">
      <div class="side-modal-content">
          <div class="side-modal-header">
              <h3 id="modal-title">Yangi talaba yaratish</h3>
              <button class="close-modal-btn" aria-label="Close modal">
                  <i class="ri-close-line"></i>
              </button>
          </div>
          <form id="student-form" class="side-modal-body" action="store.php" method="post">
              <div class="form-group">
                  <label for="student-name">Ism:</label>
                  <input type="text" id="student-name" name="name" required>
              </div>
              <div class="form-group">
                  <label for="student-phone">Telefon raqami:</label>
                  <input type="tel" id="student-phone" name="mobile_numer" required>
              </div>

              <div class="side-modal-footer">
                  <button type="submit" class="primary-button" onclick="document.getElementById('student-form').submit();">Saqlash</button>
                  <button type="button" class="secondary-button close-modal-btn">Bekor qilish</button>
              </div>
          </form>
      </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
