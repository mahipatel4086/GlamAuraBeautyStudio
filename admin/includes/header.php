 
 <style>
      :root{
      --blush: #F6D0D6;
      --rose-gold: #CFA46A;
      --ivory: #FFF8F3;
      --mauve: #a77f8c;
      --plum: #472634;
      

      --glass-alpha: rgba(255,255,255,0.55);
      --accent-gradient: none;
      --card-radius: 14px;
    }

    /* Reset & body */
    *{box-sizing:border-box}
    * {
  box-sizing: border-box;
}

body {
  margin: 0;
  padding: 0;
  background: #FFF8F3;
  font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
}

/* MAIN LAYOUT */

/* SIDEBAR */
    .sidebar {
  background: #9F6771;
  color:#fff;
  border-radius: 16px;
  padding: 22px;
  height: 730px;     /* Increased height */
  position: sticky;
  top: 20px;
  margin-left: -30px;
  margin-top: 10px;
  padding-bottom: 70px;
  box-shadow: 0 20px 50px rgba(71,38,52,0.28);
}
    .brand {
      display:flex;align-items:center;gap:12px;margin-bottom:18px;
    }
    .logo-mark{
      width:48px;height:48px;border-radius:12px;background:#DDADA0;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-family:'Playfair Display',serif;font-size:18px;
      box-shadow: 0 6px 18px rgba(207,164,106,0.25);
    }
    .brand h1{font-size:1.05rem;margin:0;font-family:'Playfair Display',serif}
    .brand p{margin:0;font-size:.72rem;color:rgba(255,255,255,0.85)}
    .nav-side {margin-top:14px}
    .nav-side a{
      display:flex;align-items:center;gap:10px;color:rgba(255,255,255,0.95);padding:10px;border-radius:10px;margin-bottom:6px;text-decoration:none;
    }
    .nav-side a .bi{font-size:18px}
    .nav-side a:hover, .nav-side a.active{background:rgba(255,255,255,0.06);transform:translateX(4px)}
    .sidebar .small-muted{color:rgba(255,255,255,0.6);font-size:.78rem;margin-top:12px}

    /* MAIN */


/* Page background (same as dashboard) */
/* ROOT COLORS (Theme Same As Your Dashboard) */
:root {
    --blush: #F6D0D6;
    --rose-gold: #CFA46A;
    --ivory: #FFF8F3;
    --mauve: #a77f8c;
    --plum: #472634;
}


body {
    background: #FFF8F3;
    margin: 0;
    padding: 40px;
    font-family: 'Poppins', sans-serif;
    color: var(--plum);
}

.heading-row {
    display: flex;
    justify-content: space-between; 
    align-items: center;            
        margin-bottom: 20px;
}

.right-buttons {
    display: flex;
    gap: 12px; 
}

.btn {
    background: var(--mauve);
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 6px 14px rgba(0,0,0,0.08);
    transition: 0.3s ease;
}

.btn:hover {
    background: var(--plum);
    transform: translateY(-3px);
}

  </style>
 <div class="app">
    <aside class="sidebar">
      <div class="brand">
        <div class="logo-mark">G</div>
        <div>
          <h1 style="font-size:1rem;margin:0">Glam Studio</h1>
          <p style="margin:0">Admin Panel</p>
        </div>
      </div>

    <nav class="nav-side">
      <a href="dashboard.php"><i class="bi bi-speedometer2"></i><span> Dashboard</span></a>
      <a href="admin.php"><i class="bi bi-person-badge"></i><span> Admin Users</span></a>
      <a href="booking.php"><i class="bi bi-calendar2-check"></i><span> Appointments</span></a>
      <a href="customer.php"><i class="bi bi-people-fill"></i><span> Clients</span></a>
      <a href="category.php"><i class="bi bi-stars"></i><span> Categories</span></a>
      <a href="service.php"><i class="bi bi-scissors"></i><span> Services</span></a>
      <a href="staff.php"><i class="bi bi-people"></i><span> Staff</span></a>
      <a href="whatsapp_notifications.php"><i class="bi bi-app-indicator"></i><span> Notifications</span></a>
      <a href="offer.php"><i class="bi bi-gift"></i><span> Offers</span></a>
      <a href="reviews.php"><i class="bi bi-star"></i><span> Reviews</span></a>
      <a href="branch.php"><i class="bi bi-shop-window"></i><span> Branch</span></a>
      <a href="logout.php"><i class="bi bi-box-arrow-right"></i><span> Log Out</span></a>
    </nav>
    </aside>

    <main class="main">
      <div class="topbar">
        <div class="d-flex align-items-center gap-3">
          <button class="hamburger" id="hamburger" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
          </button>
          <!-- <button class="btn btn-sm"
            style="background:transparent;
                  border:1px solid rgba(71,38,52,0.06);
                  border-radius:10px;
                  color:#000;">
            <i class="bi bi-filter"></i>
          </button> -->
          <div class="search-input">
            <input class="form-control" placeholder="Search clients..." />
          </div>
        </div>

        <div class="profile-pill">
          <div class="text-end me-2">
            <div style="font-weight:700;color:var(--plum)">Admin</div>
            <div style="font-size:.82rem;color:#7a5f66">glam@studio.com</div>
          </div>
          <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=500&auto=format&fit=crop&ixlib=rb-4.0.3&s=7babb5f3f4a1b9aeb5b1f3bfa1f6b8cf" alt="admin">
        </div>
      </div>

<style>
.hamburger {
  display: none;
  background: transparent;
  border: 1px solid rgba(71,38,52,0.06);
  border-radius: 10px;
  padding: 8px;
  cursor: pointer;
}

@media (max-width: 900px) {
  .hamburger {
    display: block;
  }
}
</style>

<script>
function toggleSidebar() {
  if (window.innerWidth <= 900) {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('show');
  }
}

document.addEventListener('click', function(e) {
  if (window.innerWidth <= 900) {
    const sidebar = document.querySelector('.sidebar');
    const hamburger = document.getElementById('hamburger');
    
    if (!sidebar.contains(e.target) && 
        !hamburger.contains(e.target) && 
        sidebar.classList.contains('show')) {
      sidebar.classList.remove('show');
    }
  }
});
</script>