<?php
// detail.php
require_once 'config/db.php';

// =========================================
// SERVICE DATA - ALL 6 SERVICES WITH PRODUCTS
// =========================================
$services = [
    1 => [
        "title" => "Wedding Planning",
        "subtitle" => "From Dream to Reality — Every Detail Perfected",
        "banner" => "images/wedplaning.jpg",
        "products" => [
            [
                "id" => 101,
                "name" => "Royal Wedding Package",
                "image" => "./images/d.royalwed.jpg",
                "badge" => "⭐ Royal Choice",
                "rating" => "4.9",
                "price" => "PKR 180,000",
                "description" => "Complete wedding planning with royal touch.",
                "features" => ["Guest Management", "Timeline Planning", "Budget Planning", "Complete Coordination"]
            ],
            [
                "id" => 102,
                "name" => "Luxury Wedding Planner",
                "image" => "./images/d.luxury.jpg",
                "badge" => "✨ Premium",
                "rating" => "4.8",
                "price" => "PKR 250,000",
                "description" => "Premium planning with luxury experience.",
                "features" => ["Vendor Selection", "Theme Design", "Full Coordination", "On-site Management"]
            ],
            [
                "id" => 103,
                "name" => "Destination Wedding Planner",
                "image" => "./images/d.destinationwed.jpg",
                "badge" => "🌍 Best Seller",
                "rating" => "4.7",
                "price" => "PKR 450,000",
                "description" => "Complete destination wedding planning.",
                "features" => ["Venue Selection", "Travel Arrangements", "Guest Accommodation", "Full Coordination"]
            ],
            [
                "id" => 104,
                "name" => "Elite Couple Planning",
                "image" => "./images/d.elitecouple.jpg",
                "badge" => "💎 Elite",
                "rating" => "4.9",
                "price" => "PKR 320,000",
                "description" => "Exclusive planning for elite couples.",
                "features" => ["Personal Concierge", "Luxury Vendors", "Custom Design", "VIP Experience"]
            ],
            [
                "id" => 105,
                "name" => "Royal Family Package",
                "image" => "./images/d.royalfam.jpg",
                "badge" => "👑 Royal",
                "rating" => "4.9",
                "price" => "PKR 580,000",
                "description" => "Complete family wedding planning.",
                "features" => ["Family Coordination", "Multi-Event Planning", "Royal Theme", "Full Management"]
            ],
            [
                "id" => 106,
                "name" => "Premium VIP Wedding",
                "image" => "./images/d.premiumvip.jpg",
                "badge" => "⭐ Premium VIP",
                "rating" => "5.0",
                "price" => "PKR 900,000",
                "description" => "Ultimate VIP wedding experience.",
                "features" => ["VIP Concierge", "Luxury Transport", "Celebrity Management", "Full Production"]
            ]
        ]
    ],
    2 => [
        "title" => "Décor & Styling",
        "subtitle" => "Transforming Venues Into Royal Wedding Experiences",
        "banner" => "images/luxdecoration.jpg",
        "products" => [
            [
                "id" => 201,
                "name" => "Royal Stage Setup",
                "image" => "./images/ds.place.jpg",
                "badge" => "👑 Royal",
                "rating" => "4.9",
                "price" => "PKR 180,000",
                "description" => "Luxurious stage decoration with royal theme.",
                "features" => ["Stage Design", "Premium Fabrics", "Royal Lighting", "Custom Backdrop"]
            ],
            [
                "id" => 202,
                "name" => "Luxury Floral Decoration",
                "image" => "./images/ds.floraldecor.jpg",
                "badge" => "🌸 Premium",
                "rating" => "4.8",
                "price" => "PKR 95,000",
                "description" => "Breathtaking floral arrangements.",
                "features" => ["Premium Flowers", "Custom Design", "Fresh Arrangements", "Full Setup"]
            ],
            [
                "id" => 203,
                "name" => "Golden Entrance Decoration",
                "image" => "./images/ds.entrance.jpg",
                "badge" => "✨ Gold Standard",
                "rating" => "4.7",
                "price" => "PKR 120,000",
                "description" => "Grand entrance with golden theme.",
                "features" => ["Golden Gate", "Premium Drapery", "Royal Lighting", "Custom Design"]
            ],
            [
                "id" => 204,
                "name" => "Crystal Theme Decoration",
                "image" => "./images/ds.crystal.jpg",
                "badge" => "💎 Crystal",
                "rating" => "4.9",
                "price" => "PKR 250,000",
                "description" => "Elegant crystal themed decoration.",
                "features" => ["Crystal Chandeliers", "Premium Lighting", "Luxury Fabrics", "Complete Setup"]
            ],
            [
                "id" => 205,
                "name" => "Luxury Ceiling Decoration",
                "image" => "./images/ds.ceiling.jpg",
                "badge" => "🌟 Premium",
                "rating" => "4.8",
                "price" => "PKR 300,000",
                "description" => "Stunning ceiling decoration with lights.",
                "features" => ["Ceiling Design", "LED Lighting", "Premium Fabric", "Custom Setup"]
            ],
            [
                "id" => 206,
                "name" => "Complete Palace Decoration",
                "image" => "./images/ds.completedecor.jpg",
                "badge" => "🏰 Palace",
                "rating" => "5.0",
                "price" => "PKR 650,000",
                "description" => "Full palace style decoration.",
                "features" => ["Full Venue Styling", "Royal Furniture", "Luxury Lighting", "Complete Management"]
            ]
        ]
    ],
    3 => [
        "title" => "Photography & Films",
        "subtitle" => "Capturing Every Emotion, Every Moment",
        "banner" => "images/servicespic3.jpg",
        "products" => [
            [
                "id" => 301,
                "name" => "Wedding Photoshoot",
                "image" => "./images/fp.wedphoto.jpg",
                "badge" => "📸 Best Seller",
                "rating" => "4.8",
                "price" => "PKR 55,000",
                "description" => "Professional wedding photography.",
                "features" => ["4 Hours Shoot", "1 Photographer", "Digital Images", "Basic Editing"]
            ],
            [
                "id" => 302,
                "name" => "Drone Coverage",
                "image" => "./images/fp.drone.jpg",
                "badge" => "🎥 Premium",
                "rating" => "4.7",
                "price" => "PKR 35,000",
                "description" => "Aerial drone photography.",
                "features" => ["Drone Shoot", "Aerial Views", "4K Quality", "Professional Pilot"]
            ],
            [
                "id" => 303,
                "name" => "Cinematic Film",
                "image" => "./images/fp.film.jpg",
                "badge" => "🎬 Cinema",
                "rating" => "4.9",
                "price" => "PKR 120,000",
                "description" => "Cinematic wedding film.",
                "features" => ["Full Videography", "Cinematic Style", "Professional Editing", "Highlight Film"]
            ],
            [
                "id" => 304,
                "name" => "Pre Wedding Shoot",
                "image" => "./images/fp.prewed.jpg",
                "badge" => "💕 Romantic",
                "rating" => "4.8",
                "price" => "PKR 70,000",
                "description" => "Beautiful pre-wedding shoot.",
                "features" => ["Multiple Locations", "Professional Styling", "Full Coverage", "Luxury Album"]
            ],
            [
                "id" => 305,
                "name" => "Luxury Album",
                "image" => "images/fp.album.jpg",
                "badge" => "📖 Premium",
                "rating" => "4.6",
                "price" => "PKR 25,000",
                "description" => "Premium wedding album design.",
                "features" => ["Luxury Cover", "Premium Pages", "Custom Design", "High Quality Print"]
            ],
            [
                "id" => 306,
                "name" => "Complete Premium Package",
                "image" => "./images/fp.complete.jpg",
                "badge" => "⭐ Complete",
                "rating" => "5.0",
                "price" => "PKR 250,000",
                "description" => "Complete photography & film package.",
                "features" => ["12 Hours Coverage", "3 Photographers", "Full Videography", "Drone + Album"]
            ]
        ]
    ],
    4 => [
        "title" => "Catering & Cuisine",
        "subtitle" => "A Taste That Makes Your Celebration Unforgettable",
        "banner" => "images/servicespic4.jpg",
        "products" => [
            [
                "id" => 401,
                "name" => "Silver Buffet",
                "image" => "./images/c.silver.jpg",
                "badge" => "🥈 Silver",
                "rating" => "4.5",
                "price" => "PKR 2,000/head",
                "description" => "Classic buffet with delicious options.",
                "features" => ["5 Main Dishes", "2 Desserts", "Beverages", "Standard Service"]
            ],
            [
                "id" => 402,
                "name" => "Gold Buffet",
                "image" => "./images/c.golden.jpg",
                "badge" => "🥇 Gold",
                "rating" => "4.7",
                "price" => "PKR 3,500/head",
                "description" => "Premium buffet with gourmet dishes.",
                "features" => ["8 Main Dishes", "4 Desserts", "Mocktails", "Premium Service"]
            ],
            [
                "id" => 403,
                "name" => "Royal Buffet",
                "image" => "./images/c.royal.jpg",
                "badge" => "👑 Royal",
                "rating" => "4.9",
                "price" => "PKR 5,000/head",
                "description" => "Royal dining experience.",
                "features" => ["10 Main Dishes", "6 Desserts", "Welcome Drinks", "Royal Service", "Live Stations"]
            ],
            [
                "id" => 404,
                "name" => "VIP Buffet",
                "image" => "./images/c.vip.jpg",
                "badge" => "💎 VIP",
                "rating" => "4.8",
                "price" => "PKR 7,000/head",
                "description" => "VIP dining with exclusive menu.",
                "features" => ["Exclusive Menu", "Premium Ingredients", "Personal Chef", "Full Service"]
            ],
            [
                "id" => 405,
                "name" => "Dessert Station",
                "image" => "./images/c.desert.jpg",
                "badge" => "🍰 Sweet",
                "rating" => "4.6",
                "price" => "PKR 1,500/head",
                "description" => "Luxury dessert station.",
                "features" => ["10+ Desserts", "Chocolate Fountain", "Custom Cake", "Premium Service"]
            ],
            [
                "id" => 406,
                "name" => "Luxury Complete Catering",
                "image" => "./images/c.complete.jpg",
                "badge" => "⭐ Complete",
                "rating" => "5.0",
                "price" => "PKR 12,000/head",
                "description" => "Complete luxury catering package.",
                "features" => ["Full Menu", "All Stations", "Premium Service", "Custom Design", "Event Coordination"]
            ]
        ]
    ],
    5 => [
        "title" => "Entertainment",
        "subtitle" => "Making Your Celebration Truly Unforgettable",
        "banner" => "images/entertainment.jpg",
        "products" => [
            [
                "id" => 501,
                "name" => "Live Band",
                "image" => "./images/e.band.jpg",
                "badge" => "🎸 Live",
                "rating" => "4.8",
                "price" => "PKR 80,000",
                "description" => "Professional live band performance.",
                "features" => ["4 Hours Performance", "Professional Musicians", "Variety Songs", "Full Setup"]
            ],
            [
                "id" => 502,
                "name" => "DJ Night",
                "image" => "./images/e.dj.jpg",
                "badge" => "🎧 Party",
                "rating" => "4.7",
                "price" => "PKR 50,000",
                "description" => "Professional DJ for your wedding.",
                "features" => ["6 Hours Set", "Premium Sound", "Lighting Setup", "Request Management"]
            ],
            [
                "id" => 503,
                "name" => "Qawwali Night",
                "image" => "./images/e.qawali.jpg",
                "badge" => "🎤 Traditional",
                "rating" => "4.9",
                "price" => "PKR 60,000",
                "description" => "Traditional Qawwali performance.",
                "features" => ["2 Hours Show", "Professional Artists", "Traditional Setup", "Live Performance"]
            ],
            [
                "id" => 504,
                "name" => "Dhol Performance",
                "image" => "./images/e.dhol.jpg",
                "badge" => "🥁 Festive",
                "rating" => "4.6",
                "price" => "PKR 20,000",
                "description" => "Traditional Dhol performance.",
                "features" => ["Professional Dhol", "Live Performance", "Bridal Entry", "Full Energy"]
            ],
            [
                "id" => 505,
                "name" => "Fireworks Show",
                "image" => "./images/e.fire.jpg",
                "badge" => "🎆 Spectacular",
                "rating" => "5.0",
                "price" => "PKR 150,000",
                "description" => "Spectacular fireworks display.",
                "features" => ["10 Minutes Show", "Professional Setup", "Safety Certified", "Custom Design"]
            ],
            [
                "id" => 506,
                "name" => "Cold Pyro Effects",
                "image" => "./images/e.cold.jpg",
                "badge" => "❄️ Premium",
                "rating" => "4.8",
                "price" => "PKR 45,000",
                "description" => "Premium cold pyro effects.",
                "features" => ["Cold Sparks", "Professional Setup", "Safety Certified", "Custom Effects"]
            ]
        ]
    ],
    6 => [
        "title" => "Venue Management",
        "subtitle" => "The Perfect Place For Your Perfect Celebration",
        "banner" => "images/servicespic2.jpg",
        "products" => [
            [
                "id" => 601,
                "name" => "Luxury Hall Booking",
                "image" => "./images/v.hall.jpg",
                "badge" => "🏛️ Premium",
                "rating" => "4.7",
                "price" => "PKR 200,000",
                "description" => "Premium luxury hall booking.",
                "features" => ["Premium Hall", "VIP Lounge", "Backstage Area", "Full Management"]
            ],
            [
                "id" => 602,
                "name" => "Royal Ballroom",
                "image" => "./images/v.ballroom.jpg",
                "badge" => "👑 Royal",
                "rating" => "4.9",
                "price" => "PKR 400,000",
                "description" => "Royal ballroom for grand weddings.",
                "features" => ["Grand Ballroom", "Chandelier Lighting", "Royal Décor", "Complete Service"]
            ],
            [
                "id" => 603,
                "name" => "Outdoor Garden",
                "image" => "./images/v.outdoor.jpg",
                "badge" => "🌿 Garden",
                "rating" => "4.6",
                "price" => "PKR 150,000",
                "description" => "Beautiful outdoor garden venue.",
                "features" => ["Garden Setup", "Natural Lighting", "Premium Seating", "Full Service"]
            ],
            [
                "id" => 604,
                "name" => "Palace Theme Venue",
                "image" => "./images/v.venue.jpg",
                "badge" => "🏰 Palace",
                "rating" => "4.8",
                "price" => "PKR 350,000",
                "description" => "Palace themed wedding venue.",
                "features" => ["Palace Theme", "Royal Décor", "Grand Entrance", "Complete Management"]
            ],
            [
                "id" => 605,
                "name" => "VIP Lounge",
                "image" => "./images/v.lounge.jpg",
                "badge" => "💎 VIP",
                "rating" => "4.7",
                "price" => "PKR 100,000",
                "description" => "Exclusive VIP lounge for guests.",
                "features" => ["VIP Area", "Premium Seating", "Exclusive Service", "Privacy"]
            ],
            [
                "id" => 606,
                "name" => "Complete Venue Management",
                "image" => "./images/v.complete.jpg",
                "badge" => "⭐ Complete",
                "rating" => "5.0",
                "price" => "PKR 500,000",
                "description" => "Complete venue management package.",
                "features" => ["Venue Selection", "Full Decoration", "Vendor Coordination", "Day Management"]
            ]
        ]
    ]
];

// Get ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
if (!array_key_exists($id, $services)) {
    $id = 1;
}
$service = $services[$id];
$products = $service['products'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $service['title']; ?> | Noor-E-Mahal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        /* =========================================
           BASE STYLES
        ========================================= */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --gold: #d4af37;
            --gold-light: #f0d77b;
            --gold-dark: #a88920;
            --black: #0a0a0a;
            --black-light: #111111;
            --card: #151515;
            --white: #ffffff;
            --gray: #999999;
            --border: rgba(212, 175, 55, 0.22);
        }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--black);
            color: var(--white);
            overflow-x: hidden;
        }
        a { text-decoration: none; }

        /* ===== FULL PAGE BACKGROUND ===== */
        body {
            background-image: url('<?php echo $service['banner']; ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            z-index: -1;
        }

        /* ===== NAVBAR ===== */
        header {
            background: rgba(10, 10, 10, 0.85) !important;
            padding: 15px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 2px solid rgba(255, 215, 0, 0.15);
            backdrop-filter: blur(10px);
        }
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            text-decoration: none;
        }
        .logo h1 {
            font-size: 28px;
            font-weight: 900;
            color: var(--white);
            letter-spacing: -0.5px;
            font-family: 'Cinzel', serif;
        }
        .logo h1 span { color: var(--gold); }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }
        .nav-links a {
            color: var(--gray);
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s;
            position: relative;
        }
        .nav-links a:hover,
        .nav-links a.active { color: var(--gold); }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: width 0.3s;
        }
        .nav-links a:hover::after,
        .nav-links a.active::after { width: 100%; }
        .nav-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 15px;
            flex: 1;
        }
        .nav-actions .btn {
            padding: 10px 24px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary {
            background: var(--gold);
            color: var(--black);
        }
        .btn-primary:hover {
            background: var(--gold-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.3);
        }
        .btn-outline {
            background: transparent;
            color: var(--white);
            border: 2px solid var(--gold);
        }
        .btn-outline:hover {
            background: var(--gold);
            color: var(--black);
        }
        .btn-outline i { color: var(--gold); }
        .btn-outline:hover i { color: var(--black); }

        /* =========================================
           HERO / BANNER
        ========================================= */
        .service-hero {
            min-height: 50vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 80px 20px;
            background: transparent !important;
        }
        .service-hero-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            padding: 40px 20px;
        }
        .service-hero-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(42px, 6vw, 72px);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 15px;
            color: #fff;
            text-shadow: 0 4px 40px rgba(0,0,0,0.8);
            letter-spacing: 2px;
        }
        .service-hero-content p {
            color: rgba(255, 255, 255, 0.85);
            font-size: clamp(18px, 2vw, 24px);
            max-width: 700px;
            margin: auto;
            line-height: 1.8;
            text-shadow: 0 2px 30px rgba(0,0,0,0.8);
            font-weight: 300;
        }
        .back-link {
            margin-top: 20px;
        }
        .back-link a {
            color: var(--gold);
            font-size: 14px;
            transition: 0.3s;
        }
        .back-link a:hover { color: #fff; }
        .back-link a i { margin-right: 8px; }

        /* =========================================
           PRODUCTS SECTION
        ========================================= */
        .products-section {
            padding: 60px 8% 100px;
            background: transparent !important;
        }
        .section-heading {
            text-align: center;
            margin-bottom: 50px;
        }
        .section-heading .section-label {
            color: var(--gold);
            font-size: 13px;
            letter-spacing: 4px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .section-heading h2 {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            color: #fff;
            margin: 10px 0;
        }
        .section-heading h2 span { color: var(--gold); }
        .section-heading p {
            color: #ccc;
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto;
        }

        /* =========================================
           PRODUCTS GRID
        ========================================= */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            max-width: 1300px;
            margin: 0 auto;
        }

        /* =========================================
           PRODUCT CARD
        ========================================= */
        .product-card {
            position: relative;
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .product-card:hover {
            transform: translateY(-15px);
            border-color: var(--gold);
            box-shadow: 0 30px 80px rgba(212, 175, 55, 0.15), 0 0 40px rgba(212, 175, 55, 0.05);
        }

        .product-card::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 22px;
            background: linear-gradient(45deg, transparent, rgba(212, 175, 55, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.5s ease;
            z-index: -1;
        }
        .product-card:hover::before {
            opacity: 1;
        }

        /* ===== PRODUCT IMAGE ===== */
        .product-image {
            position: relative;
            width: 100%;
            height: 240px;
            overflow: hidden;
            background: #111;
        }
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* ===== BADGE ===== */
        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--gold);
            color: #000;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 5px 20px rgba(212, 175, 55, 0.3);
        }

        /* ===== RATING & WISHLIST ===== */
        .product-rating {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .product-rating .stars {
            color: var(--gold);
            font-size: 13px;
        }
        .product-rating .rating-num {
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            background: rgba(0,0,0,0.5);
            padding: 2px 10px;
            border-radius: 12px;
        }
        .wishlist-btn {
            background: rgba(255,255,255,0.1);
            border: none;
            color: #fff;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.3s;
            backdrop-filter: blur(5px);
        }
        .wishlist-btn:hover {
            background: var(--gold);
            color: #000;
            transform: scale(1.1);
        }

        /* ===== PRODUCT CONTENT ===== */
        .product-content {
            padding: 20px 25px 25px;
        }
        .product-content h3 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            color: #fff;
            margin-bottom: 6px;
        }
        .product-content .product-desc {
            color: #aaa;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        /* ===== FEATURES ===== */
        .product-features {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 15px;
        }
        .product-features span {
            background: rgba(212, 175, 55, 0.08);
            border: 1px solid rgba(212, 175, 55, 0.12);
            color: #ddd;
            font-size: 11px;
            padding: 3px 12px;
            border-radius: 12px;
            font-weight: 400;
            letter-spacing: 0.3px;
        }

        /* =========================================
           PRICE - HIDDEN (HATA DIYA)
        ========================================= */
        .product-price {
            display: none;
        }

        /* =========================================
           BUTTON - ONLY DETAILS (FULL WIDTH, BIGGER)
        ========================================= */
        .product-buttons {
            display: flex;
            gap: 0;
            margin-top: 5px;
        }
        .btn-details {
            width: 100%;
            padding: 18px 20px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(212, 175, 55, 0.05));
            border: 1.5px solid rgba(212, 175, 55, 0.4);
            color: var(--gold);
            border-radius: 30px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            letter-spacing: 0.5px;
        }
        .btn-details:hover {
            background: var(--gold);
            color: #000;
            border-color: var(--gold);
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(212, 175, 55, 0.4);
        }
        .btn-details i {
            font-size: 18px;
            transition: transform 0.3s ease;
        }
        .btn-details:hover i {
            transform: translateX(8px);
        }

        /* =========================================
           FOOTER
        ========================================= */
        .main-footer {
            background: rgba(8, 8, 8, 0.9) !important;
            padding: 60px 0 0;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
            backdrop-filter: blur(5px);
        }
        .footer-top {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1.3fr 1.3fr;
            gap: 40px;
            padding-bottom: 50px;
        }
        .footer-brand h2 {
            color: var(--gold);
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            margin-bottom: 15px;
        }
        .footer-brand p {
            color: #999;
            font-size: 14px;
            line-height: 1.8;
            max-width: 300px;
        }
        .footer-social {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }
        .footer-social a {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(212, 175, 55, 0.35);
            border-radius: 50%;
            color: var(--gold);
            text-decoration: none;
            transition: 0.35s ease;
        }
        .footer-social a:hover {
            background: var(--gold);
            color: #000;
            transform: translateY(-5px);
        }
        .footer-links h3,
        .footer-contact h3 {
            color: #fff;
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            margin-bottom: 20px;
        }
        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .footer-links a {
            color: #999;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s ease;
        }
        .footer-links a:hover {
            color: var(--gold);
            padding-left: 6px;
        }
        .footer-contact p {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            color: #999;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 14px;
        }
        .footer-contact p i {
            color: var(--gold);
            margin-top: 4px;
        }
        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 20px 0;
            border-top: 1px solid rgba(255,255,255,0.04);
        }
        .footer-bottom p {
            color: #666;
            font-size: 12px;
            margin: 0;
        }
        .footer-bottom span {
            color: var(--gold);
            font-weight: 600;
        }

        /* =========================================
           RESPONSIVE
        ========================================= */
        @media (max-width: 1024px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            header { padding: 12px 20px; flex-wrap: wrap; }
            .nav-links { order: 3; flex: 0 0 100%; justify-content: center; gap: 10px; margin-top: 10px; flex-wrap: wrap; }
            .nav-links a { font-size: 13px; }
            .nav-actions .btn { padding: 8px 16px; font-size: 12px; }
            .service-hero { min-height: 40vh; padding: 60px 20px; }
            .service-hero-content h1 { font-size: 32px; }
            .products-grid { grid-template-columns: 1fr; max-width: 450px; margin: 0 auto; }
            .section-heading h2 { font-size: 30px; }
            .products-section { padding: 40px 5% 60px; }
            .product-image { height: 180px; }
            .footer-top { grid-template-columns: 1fr; gap: 30px; }
            .footer-bottom { flex-direction: column; text-align: center; }
            .btn-details { padding: 16px 20px; font-size: 15px; }
        }
    </style>
</head>
<body>

<!-- ===== HEADER ===== -->
<header>
    <nav class="nav-links">
        <a href="events.php">Events</a>
        <a href="packages.php">Packages</a>
        <a href="services.php">Services</a>
        <a href="about_us.php">About</a>
        <a href="faqs.php">FAQs</a>
        <a href="contact_us.php">Contact</a>
    </nav>

    <a href="index.php" class="logo">
        <h1>Noor e <span>Mehal</span></h1>
    </a>

    <div class="nav-actions">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="btn btn-outline"><i class="fas fa-sign-out-alt"></i> Logout</a>
            <a href="index.php" class="btn btn-primary"><i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
        <?php else: ?>
            <a href="login.php" class="btn btn-outline"><i class="fas fa-sign-in-alt"></i> Login</a>
            <a href="register.php" class="btn btn-primary"><i class="fas fa-user-plus"></i> Register</a>
        <?php endif; ?>
    </div>
</header>

<!-- ===== SERVICE HERO / BANNER ===== -->
<section class="service-hero">
    <div class="service-hero-content">
        <h1><?php echo $service['title']; ?></h1>
        <p><?php echo $service['subtitle']; ?></p>
        <div class="back-link">
            <a href="services.php"><i class="fas fa-arrow-left"></i> Back to All Services</a>
        </div>
    </div>
</section>

<!-- ===== PRODUCTS SECTION ===== -->
<section class="products-section">
    <div class="section-heading">
        <span class="section-label">Our Premium Packages</span>
        <h2>Choose Your <span>Perfect Experience</span></h2>
        <p>Select from our luxury wedding packages designed to make your special day unforgettable.</p>
    </div>

    <div class="products-grid">
        <?php foreach ($products as $product): ?>
        <div class="product-card">
            <div class="product-image">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <div class="product-badge"><?php echo $product['badge']; ?></div>
                <div class="product-rating">
                    <span class="stars">⭐</span>
                    <span class="rating-num"><?php echo $product['rating']; ?></span>
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                </div>
            </div>

            <div class="product-content">
                <h3><?php echo $product['name']; ?></h3>
                <p class="product-desc"><?php echo $product['description']; ?></p>
                
                <div class="product-features">
                    <?php foreach ($product['features'] as $feature): ?>
                        <span>✔ <?php echo $feature; ?></span>
                    <?php endforeach; ?>
                </div>

                <!-- PRICE HATAYA - DISPLAY NONE -->

                <!-- ===== SIRF DETAILS BUTTON - FULL WIDTH, BIGGER ===== -->
                <div class="product-buttons">
                    <a href="product.php?product=<?php echo $product['id']; ?>&service=<?php echo $id; ?>" class="btn-details">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="main-footer">
    <div class="container">
        <div class="footer-top">
            <div class="footer-brand">
                <h2>Noor-E-Mahal</h2>
                <p>Creating beautiful weddings, unforgettable moments and celebrations that stay in your heart forever.</p>
                <div class="footer-social">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                </div>
            </div>

            <div class="footer-links">
                <h3>Quick Links</h3>
                <a href="index.php">Home</a>
                <a href="about_us.php">About Us</a>
                <a href="services.php">Services</a>
                <a href="gallery.php">Gallery</a>
                <a href="contact_us.php">Contact</a>
            </div>

            <div class="footer-links">
                <h3>Our Services</h3>
                <a href="detail.php?id=1">Wedding Planning</a>
                <a href="detail.php?id=2">Décor & Styling</a>
                <a href="detail.php?id=3">Photography & Films</a>
                <a href="detail.php?id=4">Catering & Cuisine</a>
                <a href="detail.php?id=5">Entertainment</a>
            </div>

            <div class="footer-contact">
                <h3>Get In Touch</h3>
                <p><i class="fas fa-location-dot"></i> Karachi, Pakistan</p>
                <p><i class="fas fa-phone"></i> +92 300 1234567</p>
                <p><i class="fas fa-envelope"></i> info@nooremahal.com</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© <?php echo date('Y'); ?> Noor-E-Mahal. All Rights Reserved.</p>
            <p>Developed by <span>INSHAL AKBER</span></p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>