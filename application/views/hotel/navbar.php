<?php
	$hotel_id = $this->session->userdata('hotel_id');
	$hotel_data = $this->My_model->select_where("hotel", array("hotel_id" => $hotel_id,));
	$default_path = base_url()."assets/img/icons/icon-48x48.png";
	$hotel_image_path = base_url()."uploads/".$_SESSION['hotel_image'];
?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="<?= isset($_SESSION['hotel_image']) && !empty($_SESSION['hotel_image']) ? $hotel_image_path : $default_path ?>" />
    
    <link rel="canonical" href="https://demo-basic.adminkit.io/" />
    <title><?= isset($_SESSION['hotel_name']) ? $_SESSION['hotel_name'] : 'Hotel' ?> | Admin</title>
    
    <link href="<?=base_url("/assets/")?>css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

<title>HotelHub - QR-Based Hotel Management System | Kumar Dalvi</title>
<meta name="description" content="HotelHub by Kumar Dalvi is a one-stop solution for hotels, offering a QR-based management system for seamless hotel operations, digital menus, and automated billing.">
<meta name="keywords" content="HotelHub, QR hotel system, hotel management software, digital hotel service, hotel automation, hotel technology, Kumar Dalvi, smart hotel solutions, best hotel system">
<meta name="author" content="Kumar Dalvi">
<meta name="robots" content="index, follow">
<meta property="og:title" content="HotelHub - Smart QR-Based Hotel Management System">
<meta property="og:description" content="Transform your hotel's operations with HotelHub, a cutting-edge QR-based system for seamless guest experiences, digital menus, and automated billing.">
<meta property="og:image" content="https://hotelhub.free.nf/assets/hotelhub_logo.jpg">
<meta property="og:url" content="https://hotelhub.free.nf/">
<meta name="twitter:card" content="summary_large_image">
<link rel="canonical" href="https://hotelhub.free.nf/">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
    "@type": "SoftwareApplication",
      "name": "HotelHub",
        "operatingSystem": "Web-based",
          "applicationCategory": "Hotel Management Software",
            "developer": {
                "@type": "Person",
                    "name": "Kumar Dalvi",
                        "email": "kumardalvi2019@gmail.com",
                            "telephone": "+91 9730164147",
                                "address": {
                                      "@type": "PostalAddress",
                                            "streetAddress": "Morya Park, MIDC",
                                                  "addressLocality": "Ahmednagar",
                                                        "addressRegion": "MH",
                                                              "postalCode": "414001",
                                                                    "addressCountry": "IN"
                                                                        }
                                                                          },
                                                                            "description": "HotelHub is a QR-based hotel management solution providing digital ordering, seamless guest experiences, and automated billing.",
                                                                              "image": "https://hotelhub.free.nf/assets/hotelhub_logo.jpg",
                                                                                "url": "https://hotelhub.free.nf/"
                                                                                }
                                                                                </script>
                                                                                <meta name="google-site-verification" content="q162OTwOVSPSkrSQW9pFSWRFZ3t71OhoKmyzRiGLFSM" />

</head>
<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar bg-dark text-light">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand text-light d-flex align-items-center" href="<?=base_url()?>">
                    <span class="align-middle" style="letter-spacing: 3px; font-size: 18px;">
                        <?= isset($_SESSION['hotel_name']) ? $_SESSION['hotel_name'] : 'Hotel' ?>
                    </span>
                </a>
                <ul class="sidebar-nav">
                    <li class="sidebar-item <?= $this->uri->segment(2) == '' ? 'active' : '' ?>">
                        <a class="sidebar-link" href="<?=base_url()?>">
                            <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= $this->uri->segment(2) == 'manage_table' ? 'active' : '' ?>">
                        <a class="sidebar-link" href="<?=base_url()?>hotel/manage_table">
                            <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Manage Table</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= $this->uri->segment(2) == 'manage_category' ? 'active' : '' ?>">
                        <a class="sidebar-link" href="<?=base_url()?>hotel/manage_category">
                            <i class="align-middle" data-feather="list"></i> <span class="align-middle">Manage Category</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= $this->uri->segment(2) == 'add_product' ? 'active' : '' ?>">
                        <a class="sidebar-link" href="<?=base_url()?>hotel/add_product">
                            <i class="align-middle" data-feather="plus-square"></i> <span class="align-middle">Add Product</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= $this->uri->segment(2) == 'product_list' ? 'active' : '' ?>">
                        <a class="sidebar-link" href="<?=base_url()?>hotel/product_list">
                            <i class="align-middle" data-feather="package"></i> <span class="align-middle">Product List</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= $this->uri->segment(2) == 'order_records' ? 'active' : '' ?>">
                        <a class="sidebar-link" href="<?=base_url()?>hotel/order_records">
                            <i class="align-middle" data-feather="shopping-cart"></i> <span class="align-middle">Order Records</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="main">
            <nav class="navbar navbar-expand navbar-light bg-white shadow-sm">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                                <img src="<?= isset($_SESSION['hotel_image']) && !empty($_SESSION['hotel_image']) ? $hotel_image_path : $default_path ?>" class="avatar img-fluid rounded-circle me-2" alt="Hotel Image" />
                                <span class="text-dark">Admin</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="<?=base_url()?>hotel/profile"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?=base_url()?>hotel/change_password"><i class="align-middle me-1" data-feather="settings"></i> Change Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?=base_url()?>hotel/log_out">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <script>
                feather.replace();
            </script>
            <main class="content">
                <div class="container-fluid p-0">
                   