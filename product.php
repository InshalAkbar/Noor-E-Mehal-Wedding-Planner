<?php
// ============================================
// product.php - Complete Product Page (All 36 Products)
// FIXED: Sub-product page background = sub-product ki apni image
// ============================================

error_reporting(E_ALL);
ini_set('display_errors', 1);

$product_id = isset($_GET['product']) ? (int)$_GET['product'] : 101;
$service_id = isset($_GET['service']) ? (int)$_GET['service'] : 0;

// ============================================
// AUTO-DERIVE SERVICE ID (agar URL me service param nahi hai)
// ============================================
if ($service_id == 0) {
    if ($product_id >= 1000) {
        $parent_id = (int)floor($product_id / 10);
        $service_id = (int)floor($parent_id / 100);
    } else {
        $service_id = (int)floor($product_id / 100);
    }
}

// ============================================
// FALLBACK IMAGES (agar koi image file missing ho)
// ============================================
$fallback_images = [
    101 => "./images/wedplaning.jpg",
    102 => "./images/wedplaning.jpg",
    103 => "./images/wedplaning.jpg",
    104 => "./images/wedplaning.jpg",
    105 => "./images/wedplaning.jpg",
    106 => "./images/wedplaning.jpg",
    201 => "./images/luxdecoration.jpg",
    202 => "./images/luxdecoration.jpg",
    203 => "./images/luxdecoration.jpg",
    204 => "./images/luxdecoration.jpg",
    205 => "./images/luxdecoration.jpg",
    206 => "./images/luxdecoration.jpg",
    301 => "./images/servicespic3.jpg",
    302 => "./images/servicespic3.jpg",
    303 => "./images/servicespic3.jpg",
    304 => "./images/servicespic3.jpg",
    305 => "./images/servicespic3.jpg",
    306 => "./images/servicespic3.jpg",
    401 => "./images/servicespic4.jpg",
    402 => "./images/servicespic4.jpg",
    403 => "./images/servicespic4.jpg",
    404 => "./images/servicespic4.jpg",
    405 => "./images/servicespic4.jpg",
    406 => "./images/servicespic4.jpg",
    501 => "./images/entertainment.jpg",
    502 => "./images/entertainment.jpg",
    503 => "./images/entertainment.jpg",
    504 => "./images/entertainment.jpg",
    505 => "./images/entertainment.jpg",
    506 => "./images/entertainment.jpg",
    601 => "./images/servicespic2.jpg",
    602 => "./images/servicespic2.jpg",
    603 => "./images/servicespic2.jpg",
    604 => "./images/servicespic2.jpg",
    605 => "./images/servicespic2.jpg",
    606 => "./images/servicespic2.jpg"
];

// ============================================
// SERVICE BANNER IMAGES (detail.php se match)
// ============================================
$service_banners = [
    1 => "./images/wedplaning.jpg",
    2 => "./images/luxdecoration.jpg",
    3 => "./images/servicespic3.jpg",
    4 => "./images/servicespic4.jpg",
    5 => "./images/entertainment.jpg",
    6 => "./images/servicespic2.jpg"
];

// ============================================
// MAIN PRODUCT DATA
// ============================================
$main_product_data = [
    101 => ["title" => "Wedding Planning", "subtitle" => "Complete Wedding Planning Services", "image" => "./images/wedplaning.jpg", "guests" => "100-2000+ Guests", "capacity" => "Any Size", "timing" => "Full Day Coverage", "location" => "Worldwide", "type" => "Planning Service"],
    102 => ["title" => "Luxury Wedding Planner", "subtitle" => "Premium Luxury Wedding Planning", "image" => "./images/wedplaning.jpg", "guests" => "100-2000+ Guests", "capacity" => "Any Size", "timing" => "Full Day Coverage", "location" => "Worldwide", "type" => "Luxury Planning"],
    103 => ["title" => "Destination Wedding Planner", "subtitle" => "Exotic Destination Weddings", "image" => "./images/wedplaning.jpg", "guests" => "50-500+ Guests", "capacity" => "Any Size", "timing" => "3-7 Days Coverage", "location" => "Worldwide", "type" => "Destination Planning"],
    104 => ["title" => "Elite Couple Planning", "subtitle" => "VIP Elite Wedding Experience", "image" => "./images/wedplaning.jpg", "guests" => "100-1000+ Guests", "capacity" => "Any Size", "timing" => "Full Day Coverage", "location" => "Worldwide", "type" => "Elite Service"],
    105 => ["title" => "Royal Family Package", "subtitle" => "Complete Royal Family Wedding", "image" => "./images/wedplaning.jpg", "guests" => "500-5000+ Guests", "capacity" => "Any Size", "timing" => "3-7 Days Coverage", "location" => "Worldwide", "type" => "Royal Family"],
    106 => ["title" => "Premium VIP Wedding", "subtitle" => "Ultimate VIP Wedding Experience", "image" => "./images/wedplaning.jpg", "guests" => "200-2000+ Guests", "capacity" => "Any Size", "timing" => "2-4 Days Coverage", "location" => "Worldwide", "type" => "VIP Premium"],
    201 => ["title" => "Royal Stage Setup", "subtitle" => "Premium Stage Decoration", "image" => "./images/stage1.jpg", "guests" => "N/A", "capacity" => "Any Stage", "timing" => "4-8 Hours Setup", "location" => "On-Site", "type" => "Stage Decor"],
    202 => ["title" => "Luxury Floral Decoration", "subtitle" => "Premium Floral Arrangements", "image" => "./images/floral1.jpg", "guests" => "N/A", "capacity" => "Any Size", "timing" => "4-6 Hours Setup", "location" => "On-Site", "type" => "Floral Decor"],
    203 => ["title" => "Golden Entrance Decoration", "subtitle" => "Royal Golden Entrance", "image" => "./images/enter1.jpg", "guests" => "N/A", "capacity" => "Any Size", "timing" => "3-5 Hours Setup", "location" => "On-Site", "type" => "Entrance Decor"],
    204 => ["title" => "Crystal Theme Decoration", "subtitle" => "Elegant Crystal Decor", "image" => "./images/crystal1.jpg", "guests" => "N/A", "capacity" => "Any Size", "timing" => "5-8 Hours Setup", "location" => "On-Site", "type" => "Crystal Decor"],
    205 => ["title" => "Luxury Ceiling Decoration", "subtitle" => "Premium Ceiling Decor", "image" => "./images/cieling1.jpg", "guests" => "N/A", "capacity" => "Any Size", "timing" => "4-7 Hours Setup", "location" => "On-Site", "type" => "Ceiling Decor"],
    206 => ["title" => "Complete Palace Decoration", "subtitle" => "Full Palace Styling", "image" => "./images/c.vip.jpg", "guests" => "N/A", "capacity" => "Any Size", "timing" => "Full Day Setup", "location" => "On-Site", "type" => "Palace Decor"],
    301 => ["title" => "Wedding Photoshoot", "subtitle" => "Professional Wedding Photography", "image" => "./images/weddingpic.jpg", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "6-12 Hours", "location" => "Worldwide", "type" => "Photography"],
    302 => ["title" => "Drone Coverage", "subtitle" => "Aerial Wedding Photography", "image" => "./images/servicespic3.jpg", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "2-6 Hours", "location" => "Worldwide", "type" => "Drone Service"],
    303 => ["title" => "Cinematic Film", "subtitle" => "Professional Wedding Filmmaking", "image" => "./images/servicespic3.jpg", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "8-14 Hours", "location" => "Worldwide", "type" => "Videography"],
    304 => ["title" => "Pre Wedding Shoot", "subtitle" => "Beautiful Pre-Wedding Photography", "image" => "./images/weddingpic.jpg", "guests" => "2-20 Guests", "capacity" => "Small Groups", "timing" => "4-8 Hours", "location" => "Worldwide", "type" => "Photography"],
    305 => ["title" => "Luxury Album", "subtitle" => "Premium Wedding Album", "image" => "./images/gallerypic1.jpg", "guests" => "N/A", "capacity" => "Any Size", "timing" => "2-4 Weeks Delivery", "location" => "Worldwide", "type" => "Album Service"],
    306 => ["title" => "Complete Premium Package", "subtitle" => "All-In-One Photography Package", "image" => "./images/servicespic3.jpg", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "Full Day Coverage", "location" => "Worldwide", "type" => "Complete Package"],
    401 => ["title" => "Silver Buffet", "subtitle" => "Classic Wedding Buffet", "image" => "./images/servicespic4.jpg", "guests" => "50-1000+ Guests", "capacity" => "Any Size", "timing" => "3-5 Hours Service", "location" => "On-Site", "type" => "Buffet Service"],
    402 => ["title" => "Gold Buffet", "subtitle" => "Premium Gold Buffet", "image" => "./images/servicespic4.jpg", "guests" => "50-1000+ Guests", "capacity" => "Any Size", "timing" => "3-5 Hours Service", "location" => "On-Site", "type" => "Buffet Service"],
    403 => ["title" => "Royal Buffet", "subtitle" => "Royal Dining Experience", "image" => "./images/servicespic4.jpg", "guests" => "100-2000+ Guests", "capacity" => "Any Size", "timing" => "4-6 Hours Service", "location" => "On-Site", "type" => "Royal Buffet"],
    404 => ["title" => "VIP Buffet", "subtitle" => "VIP Dining Experience", "image" => "./images/servicespic4.jpg", "guests" => "50-500+ Guests", "capacity" => "Any Size", "timing" => "4-6 Hours Service", "location" => "On-Site", "type" => "VIP Buffet"],
    405 => ["title" => "Dessert Station", "subtitle" => "Luxury Dessert Station", "image" => "./images/servicespic4.jpg", "guests" => "50-1000+ Guests", "capacity" => "Any Size", "timing" => "3-5 Hours Service", "location" => "On-Site", "type" => "Dessert Service"],
    406 => ["title" => "Luxury Complete Catering", "subtitle" => "Complete Luxury Catering", "image" => "./images/servicespic4.jpg", "guests" => "100-2000+ Guests", "capacity" => "Any Size", "timing" => "Full Day Service", "location" => "On-Site", "type" => "Complete Catering"],
    501 => ["title" => "Live Band", "subtitle" => "Professional Live Band Performance", "image" => "./images/entertainment.jpg", "guests" => "50-2000+ Guests", "capacity" => "Any Size", "timing" => "3-5 Hours", "location" => "On-Site", "type" => "Live Entertainment"],
    502 => ["title" => "DJ Night", "subtitle" => "Professional Wedding DJ", "image" => "./images/entertainment.jpg", "guests" => "50-2000+ Guests", "capacity" => "Any Size", "timing" => "4-8 Hours", "location" => "On-Site", "type" => "DJ Service"],
    503 => ["title" => "Qawwali Night", "subtitle" => "Traditional Qawwali Performance", "image" => "./images/entertainment.jpg", "guests" => "50-2000+ Guests", "capacity" => "Any Size", "timing" => "3-4 Hours", "location" => "On-Site", "type" => "Qawwali"],
    504 => ["title" => "Dhol Performance", "subtitle" => "Traditional Dhol Team", "image" => "./images/entertainment.jpg", "guests" => "50-2000+ Guests", "capacity" => "Any Size", "timing" => "1-3 Hours", "location" => "On-Site", "type" => "Dhol Service"],
    505 => ["title" => "Fireworks Show", "subtitle" => "Spectacular Fireworks Display", "image" => "./images/entertainment.jpg", "guests" => "50-5000+ Guests", "capacity" => "Any Size", "timing" => "10-30 Minutes", "location" => "On-Site", "type" => "Fireworks"],
    506 => ["title" => "Cold Pyro Effects", "subtitle" => "Indoor Cold Spark Effects", "image" => "./images/entertainment.jpg", "guests" => "50-2000+ Guests", "capacity" => "Any Size", "timing" => "2-4 Hours", "location" => "On-Site", "type" => "Pyro Effects"],
    601 => ["title" => "Luxury Hall Booking", "subtitle" => "Premium Wedding Venue", "image" => "./images/servicespic2.jpg", "guests" => "100-2000+ Guests", "capacity" => "Any Size", "timing" => "Full Day Booking", "location" => "Worldwide", "type" => "Venue Booking"],
    602 => ["title" => "Royal Ballroom", "subtitle" => "Grand Royal Ballroom", "image" => "./images/servicespic2.jpg", "guests" => "100-2000+ Guests", "capacity" => "Any Size", "timing" => "Full Day Booking", "location" => "Worldwide", "type" => "Ballroom"],
    603 => ["title" => "Outdoor Garden", "subtitle" => "Beautiful Garden Venue", "image" => "./images/servicespic2.jpg", "guests" => "50-1000+ Guests", "capacity" => "Any Size", "timing" => "Full Day Booking", "location" => "Worldwide", "type" => "Garden Venue"],
    604 => ["title" => "Palace Theme Venue", "subtitle" => "Royal Palace Wedding Venue", "image" => "./images/servicespic2.jpg", "guests" => "100-2000+ Guests", "capacity" => "Any Size", "timing" => "Full Day Booking", "location" => "Worldwide", "type" => "Palace Venue"],
    605 => ["title" => "VIP Lounge", "subtitle" => "Luxury VIP Lounge Area", "image" => "./images/servicespic2.jpg", "guests" => "20-200 Guests", "capacity" => "Small Groups", "timing" => "Full Day Booking", "location" => "On-Site", "type" => "VIP Lounge"],
    606 => ["title" => "Complete Venue Management", "subtitle" => "Full Venue Management Service", "image" => "./images/servicespic2.jpg", "guests" => "50-5000+ Guests", "capacity" => "Any Size", "timing" => "Full Day Management", "location" => "Worldwide", "type" => "Venue Management"]
];

// ============================================
// SUB-PRODUCTS DATABASE - COMPLETE (101-606)
// ============================================
$sub_products = [];

// ---------- 101 - Wedding Planning ----------
$sub_products[101] = [
    ["id" => 1011, "title" => "Noor Palace Hall", "subtitle" => "Grand Royal Wedding Hall", "image" => "./images/rwp.grand.jpg", "price" => "$3,500", "rating" => "5.0", "guests" => "1000+ Guests", "capacity" => "1000-1500 Pax", "timing" => "6:00 PM - 12:00 AM", "location" => "Karachi, Pakistan", "type" => "Indoor Hall", "description" => "Noor Palace is a grand royal wedding hall with crystal chandeliers.", "features" => ["🏛️ 1000+ Seating", "💎 Crystal Chandeliers", "👑 Royal Décor", "🛋️ VIP Lounge", "🍽️ Premium Catering", "🎭 Stage & Backdrop"]],
    ["id" => 1012, "title" => "Imperial Hall", "subtitle" => "Luxury Imperial Wedding Venue", "image" => "./images/rwp.imperial.jpg", "price" => "$4,500", "rating" => "4.9", "guests" => "800+ Guests", "capacity" => "800-1200 Pax", "timing" => "6:00 PM - 1:00 AM", "location" => "Karachi, Pakistan", "type" => "Indoor Hall", "description" => "Imperial Hall offers a luxurious imperial theme with gold decor.", "features" => ["🏛️ 800+ Seating", "✨ Gold & White Theme", "👑 Imperial Décor", "🛋️ VIP Area", "🍽️ Gourmet Catering", "🎭 Grand Stage"]],
    ["id" => 1013, "title" => "Crystal Ballroom", "subtitle" => "Elegant Crystal Wedding Hall", "image" => "./images/rwp.ballroom.jpg", "price" => "$5,500", "rating" => "5.0", "guests" => "600+ Guests", "capacity" => "600-900 Pax", "timing" => "5:30 PM - 11:30 PM", "location" => "Karachi, Pakistan", "type" => "Indoor Hall", "description" => "Crystal Ballroom features stunning crystal decor and elegant lighting.", "features" => ["🏛️ 600+ Seating", "💎 Crystal Decor", "✨ Premium Lighting", "🛋️ Luxury Lounge", "🍽️ Fine Dining", "🎭 Elegant Stage"]],
    ["id" => 1014, "title" => "Pearl Garden Hall", "subtitle" => "Beautiful Garden Wedding Venue", "image" => "./images/rwp.garden.jpg", "price" => "$2,800", "rating" => "4.8", "guests" => "500+ Guests", "capacity" => "500-800 Pax", "timing" => "5:00 PM - 11:00 PM", "location" => "Karachi, Pakistan", "type" => "Outdoor Garden", "description" => "Pearl Garden Hall combines indoor luxury with outdoor garden beauty.", "features" => ["🏛️ 500+ Seating", "🌿 Garden View", "🌸 Floral Decor", "🛋️ Outdoor Lounge", "🍽️ Garden Catering", "🎭 Outdoor Stage"]],
    ["id" => 1015, "title" => "Royal Palace Hall", "subtitle" => "Majestic Royal Palace Wedding", "image" => "./images/rwp.royal.jpg", "price" => "$6,500", "rating" => "5.0", "guests" => "1200+ Guests", "capacity" => "1200-2000 Pax", "timing" => "6:00 PM - 2:00 AM", "location" => "Lahore, Pakistan", "type" => "Indoor Palace", "description" => "Royal Palace Hall offers a majestic palace experience.", "features" => ["🏛️ 1200+ Seating", "👑 Royal Furnishings", "💎 Crystal Chandeliers", "🛋️ Royal VIP Lounge", "🍽️ Royal Banquet", "🎭 Royal Stage"]],
    ["id" => 1016, "title" => "Diamond Hall", "subtitle" => "Premium Diamond Wedding Venue", "image" => "./images/rwp.diamond.jpg", "price" => "$7,500", "rating" => "5.0", "guests" => "1500+ Guests", "capacity" => "1500-2500 Pax", "timing" => "6:30 PM - 2:30 AM", "location" => "Dubai, UAE", "type" => "Luxury Indoor", "description" => "Diamond Hall is the ultimate premium wedding venue.", "features" => ["🏛️ 1500+ Seating", "💎 Diamond Theme", "✨ Premium Lighting", "🛋️ Elite VIP Lounge", "🍽️ 5-Star Catering", "🎭 Grand Stage"]]
];

// ---------- 102 - Luxury Wedding Planner ----------
$sub_products[102] = [
    ["id" => 1021, "title" => "Elite Wedding Planning", "subtitle" => "Complete Elite Wedding Planning", "image" => "./images/d.elitecouple.jpg", "price" => "$5,000", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "Full Day Coverage", "location" => "Worldwide", "type" => "Planning Service", "description" => "Complete elite wedding planning with personal concierge.", "features" => ["👤 Personal Concierge", "💎 Premium Vendors", "📋 Full Planning", "🎨 Custom Design", "👑 VIP Experience", "📸 Photography Included"]],
    ["id" => 1022, "title" => "Royal Wedding Planner", "subtitle" => "Royal Wedding Planning Service", "image" => "./images/weddingpic.jpg", "price" => "$8,500", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "3 Days Coverage", "location" => "Worldwide", "type" => "Royal Planning", "description" => "Royal wedding planning service with complete coordination.", "features" => ["👑 Royal Service", "📋 Full Coordination", "🎨 Theme Design", "🍽️ Royal Catering", "🎭 Decoration", "📸 Photography"]],
    ["id" => 1023, "title" => "Luxury Wedding Consultant", "subtitle" => "Luxury Wedding Consulting", "image" => "./images/consultantpic.jpg", "price" => "$4,500", "rating" => "4.9", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "Full Day Coverage", "location" => "Worldwide", "type" => "Consulting Service", "description" => "Luxury wedding consulting with personalized attention.", "features" => ["👤 Personal Consultant", "📋 Custom Planning", "💎 Luxury Vendors", "🎨 Design Consultation", "📸 Photography", "🍽️ Catering"]],
    ["id" => 1024, "title" => "VIP Wedding Manager", "subtitle" => "VIP Wedding Management", "image" => "./images/servicespic.jpg", "price" => "$6,500", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "2 Days Coverage", "location" => "Worldwide", "type" => "VIP Management", "description" => "VIP wedding management with complete on-site coordination.", "features" => ["👑 VIP Service", "📋 Full Management", "🎨 Custom Design", "🍽️ Premium Catering", "🎭 Decoration", "📸 Photography"]],
    ["id" => 1025, "title" => "Premium Wedding Planner", "subtitle" => "Premium Wedding Planning", "image" => "./images/gallerypics.jpg", "price" => "$7,000", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "Full Day Coverage", "location" => "Worldwide", "type" => "Premium Planning", "description" => "Premium wedding planning with exclusive vendors.", "features" => ["💎 Premium Service", "📋 Full Planning", "🎨 Custom Design", "🍽️ 5-Star Catering", "🎭 Luxury Decoration", "📸 Professional Photography"]],
    ["id" => 1026, "title" => "Diamond Wedding Planner", "subtitle" => "Diamond Wedding Planning", "image" => "./images/diamondpic.jpg", "price" => "$12,000", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "5 Days Coverage", "location" => "Worldwide", "type" => "Diamond Planning", "description" => "Ultimate diamond wedding planning with everything included.", "features" => ["💎 Diamond Service", "📋 Complete Planning", "🎨 Custom Design", "🍽️ World-Class Catering", "🎭 Luxury Decoration", "📸 Premium Photography", "🎆 Fireworks"]]
];

// ---------- 103 - Destination Wedding Planner ----------
$sub_products[103] = [
    ["id" => 1031, "title" => "Dubai Beach Wedding", "subtitle" => "Luxury Dubai Beach Wedding", "image" => "./images/dubai.jpg", "price" => "$15,000", "rating" => "5.0", "guests" => "100-500 Guests", "capacity" => "100-500 Pax", "timing" => "4:00 PM - 11:00 PM", "location" => "Dubai, UAE", "type" => "Beach Wedding", "description" => "Luxury beach wedding in Dubai with complete planning.", "features" => ["🏖️ Private Beach", "📋 Full Planning", "🍽️ Luxury Catering", "📸 Photography", "🏨 5-Star Hotel", "✈️ Travel Arrangements"]],
    ["id" => 1032, "title" => "Maldives Resort Wedding", "subtitle" => "Maldives Luxury Resort Wedding", "image" => "./images/maldives.jpg", "price" => "$18,000", "rating" => "5.0", "guests" => "50-300 Guests", "capacity" => "50-300 Pax", "timing" => "3:00 PM - 10:00 PM", "location" => "Maldives", "type" => "Resort Wedding", "description" => "Luxury resort wedding in Maldives with ocean views.", "features" => ["🏝️ Private Resort", "📋 Full Planning", "🍽️ Premium Catering", "📸 Photography", "🏨 Luxury Villas", "🌊 Ocean View"]],
    ["id" => 1033, "title" => "Paris Palace Wedding", "subtitle" => "Royal Paris Palace Wedding", "image" => "./images/paris.jpg", "price" => "$25,000", "rating" => "5.0", "guests" => "100-400 Guests", "capacity" => "100-400 Pax", "timing" => "5:00 PM - 12:00 AM", "location" => "Paris, France", "type" => "Palace Wedding", "description" => "Royal palace wedding in Paris with complete planning.", "features" => ["🏰 Palace Venue", "📋 Full Planning", "🍽️ French Cuisine", "📸 Photography", "🏨 5-Star Hotel", "✈️ Travel Arrangements"]],
    ["id" => 1034, "title" => "Turkey Beach Wedding", "subtitle" => "Beautiful Turkey Beach Wedding", "image" => "./images/turkey.jpg", "price" => "$10,000", "rating" => "4.9", "guests" => "100-400 Guests", "capacity" => "100-400 Pax", "timing" => "4:30 PM - 11:30 PM", "location" => "Turkey", "type" => "Beach Wedding", "description" => "Beautiful beach wedding in Turkey with natural beauty.", "features" => ["🏖️ Beach Venue", "📋 Full Planning", "🍽️ Turkish Cuisine", "📸 Photography", "🏨 Resort Stay", "✈️ Travel Arrangements"]],
    ["id" => 1035, "title" => "Bali Garden Wedding", "subtitle" => "Bali Luxury Garden Wedding", "image" => "./images/bali.jpg", "price" => "$12,000", "rating" => "5.0", "guests" => "80-300 Guests", "capacity" => "80-300 Pax", "timing" => "3:30 PM - 10:30 PM", "location" => "Bali, Indonesia", "type" => "Garden Wedding", "description" => "Luxury garden wedding in Bali with tropical beauty.", "features" => ["🌿 Garden Venue", "📋 Full Planning", "🍽️ Asian Cuisine", "📸 Photography", "🏨 Luxury Resort", "✈️ Travel Arrangements"]],
    ["id" => 1036, "title" => "Switzerland Mountain Wedding", "subtitle" => "Swiss Alps Mountain Wedding", "image" => "./images/mountain.jpg", "price" => "$20,000", "rating" => "5.0", "guests" => "50-200 Guests", "capacity" => "50-200 Pax", "timing" => "2:00 PM - 9:00 PM", "location" => "Switzerland", "type" => "Mountain Wedding", "description" => "Spectacular mountain wedding in Switzerland with breathtaking views.", "features" => ["🏔️ Mountain Venue", "📋 Full Planning", "🍽️ Swiss Cuisine", "📸 Photography", "🏨 5-Star Hotel", "✈️ Travel Arrangements"]]
];

// ---------- 104 - Elite Couple Planning ----------
$sub_products[104] = [
    ["id" => 1041, "title" => "Elite VIP Wedding", "subtitle" => "VIP Wedding Experience", "image" => "./images/walima1.jpg", "price" => "$10,000", "rating" => "5.0", "guests" => "100-500 Guests", "capacity" => "Any Size", "timing" => "Full Day", "location" => "Worldwide", "type" => "VIP Service", "description" => "VIP wedding experience with personal concierge.", "features" => ["👑 VIP Concierge", "💎 Luxury Vendors", "📋 Full Planning", "🎨 Custom Design", "🍽️ Premium Catering", "📸 Photography"]],
    ["id" => 1042, "title" => "Celebrity Wedding Planning", "subtitle" => "Celebrity Style Wedding", "image" => "./images/celebrity.jpg", "price" => "$15,000", "rating" => "5.0", "guests" => "100-500 Guests", "capacity" => "Any Size", "timing" => "Full Day", "location" => "Worldwide", "type" => "Celebrity Service", "description" => "Celebrity style wedding planning with exclusive vendors.", "features" => ["⭐ Celebrity Service", "💎 Exclusive Vendors", "📋 Full Planning", "🎨 Custom Design", "🍽️ 5-Star Catering", "📸 Celebrity Photography"]],
    ["id" => 1043, "title" => "Royal Elite Wedding", "subtitle" => "Royal Elite Wedding Experience", "image" => "./images/royalelte.jpg", "price" => "$18,000", "rating" => "5.0", "guests" => "200-800 Guests", "capacity" => "Any Size", "timing" => "2 Days", "location" => "Worldwide", "type" => "Royal Elite", "description" => "Royal elite wedding experience with complete luxury.", "features" => ["👑 Royal Service", "💎 Luxury Vendors", "📋 Full Planning", "🎨 Custom Design", "🍽️ Royal Catering", "📸 Royal Photography"]],
    ["id" => 1044, "title" => "Premium Elite Wedding", "subtitle" => "Premium Elite Wedding Package", "image" => "./images/premium.jpg", "price" => "$12,000", "rating" => "4.9", "guests" => "100-400 Guests", "capacity" => "Any Size", "timing" => "Full Day", "location" => "Worldwide", "type" => "Premium Elite", "description" => "Premium elite wedding package with complete luxury.", "features" => ["💎 Premium Service", "📋 Full Planning", "🎨 Custom Design", "🍽️ Luxury Catering", "🎭 Decoration", "📸 Photography"]],
    ["id" => 1045, "title" => "Diamond Elite Wedding", "subtitle" => "Diamond Elite Wedding Experience", "image" => "./images/diamondstyle.jpg", "price" => "$22,000", "rating" => "5.0", "guests" => "300-1000 Guests", "capacity" => "Any Size", "timing" => "3 Days", "location" => "Worldwide", "type" => "Diamond Elite", "description" => "Diamond elite wedding experience with ultimate luxury.", "features" => ["💎 Diamond Service", "📋 Full Planning", "🎨 Custom Design", "🍽️ World-Class Catering", "🎭 Luxury Decoration", "📸 Premium Photography", "🎆 Fireworks"]],
    ["id" => 1046, "title" => "Luxury Elite Wedding", "subtitle" => "Luxury Elite Wedding Package", "image" => "./images/luxury.jpg", "price" => "$8,500", "rating" => "4.9", "guests" => "50-300 Guests", "capacity" => "Any Size", "timing" => "Full Day", "location" => "Worldwide", "type" => "Luxury Elite", "description" => "Luxury elite wedding package with premium service.", "features" => ["👤 Personal Concierge", "💎 Luxury Vendors", "📋 Full Planning", "🎨 Custom Design", "🍽️ Premium Catering", "📸 Photography"]]
];

// ---------- 105 - Royal Family Package ----------
$sub_products[105] = [
    ["id" => 1051, "title" => "Royal Family Wedding", "subtitle" => "Complete Royal Family Wedding", "image" => "./images/c.royal.jpg", "price" => "$20,000", "rating" => "5.0", "guests" => "500-2000 Guests", "capacity" => "Any Size", "timing" => "3 Days", "location" => "Worldwide", "type" => "Royal Family", "description" => "Complete royal family wedding with multi-event coordination.", "features" => ["👑 Royal Theme", "📋 Multi-Event Planning", "👨‍👩‍👧‍👦 Family Coordination", "🍽️ Royal Catering", "🎭 Grand Decoration", "🎵 Live Entertainment", "🎆 Fireworks"]],
    ["id" => 1052, "title" => "Royal Family Celebration", "subtitle" => "Luxury Family Wedding Celebration", "image" => "./images/familycelebrate.jpg", "price" => "$15,000", "rating" => "4.9", "guests" => "300-1000 Guests", "capacity" => "Any Size", "timing" => "2 Days", "location" => "Worldwide", "type" => "Family Celebration", "description" => "Luxury family wedding celebration with complete planning.", "features" => ["👑 Royal Theme", "📋 Full Planning", "👨‍👩‍👧‍👦 Family Coordination", "🍽️ Premium Catering", "🎭 Decoration", "🎵 Live Entertainment"]],
    ["id" => 1053, "title" => "Royal Family Festival", "subtitle" => "Grand Royal Family Festival", "image" => "./images/familyfes.jpg", "price" => "$25,000", "rating" => "5.0", "guests" => "800-3000 Guests", "capacity" => "Any Size", "timing" => "5 Days", "location" => "Worldwide", "type" => "Royal Festival", "description" => "Grand royal family festival with multiple events.", "features" => ["👑 Royal Theme", "📋 Multi-Event Planning", "👨‍👩‍👧‍👦 Family Coordination", "🍽️ Royal Catering", "🎭 Grand Decoration", "🎵 Live Entertainment", "🎆 Fireworks", "🎪 Entertainment"]],
    ["id" => 1054, "title" => "Royal Family Gala", "subtitle" => "Elegant Royal Family Gala", "image" => "./images/familygala.jpg", "price" => "$18,000", "rating" => "5.0", "guests" => "400-1500 Guests", "capacity" => "Any Size", "timing" => "2 Days", "location" => "Worldwide", "type" => "Royal Gala", "description" => "Elegant royal family gala with premium service.", "features" => ["👑 Royal Theme", "📋 Full Planning", "👨‍👩‍👧‍👦 Family Coordination", "🍽️ Luxury Catering", "🎭 Elegant Decoration", "🎵 Live Music"]],
    ["id" => 1055, "title" => "Royal Family Retreat", "subtitle" => "Luxury Family Wedding Retreat", "image" => "./images/familyrecreate.jpg", "price" => "$22,000", "rating" => "5.0", "guests" => "200-800 Guests", "capacity" => "Any Size", "timing" => "4 Days", "location" => "Worldwide", "type" => "Family Retreat", "description" => "Luxury family wedding retreat with complete planning.", "features" => ["👑 Royal Theme", "📋 Full Planning", "👨‍👩‍👧‍👦 Family Coordination", "🍽️ Royal Catering", "🎭 Decoration", "🎵 Live Entertainment", "🏨 Luxury Accommodation"]],
    ["id" => 1056, "title" => "Royal Family Empire", "subtitle" => "Grand Royal Family Empire Wedding", "image" => "./images/familyempire.jpg", "price" => "$35,000", "rating" => "5.0", "guests" => "1000-5000 Guests", "capacity" => "Any Size", "timing" => "7 Days", "location" => "Worldwide", "type" => "Royal Empire", "description" => "Grand royal family empire wedding with ultimate luxury.", "features" => ["👑 Royal Theme", "📋 Multi-Event Planning", "👨‍👩‍👧‍👦 Family Coordination", "🍽️ World-Class Catering", "🎭 Grand Decoration", "🎵 Live Entertainment", "🎆 Fireworks", "🏨 Luxury Accommodation"]]
];

// ---------- 106 - Premium VIP Wedding ----------
$sub_products[106] = [
    ["id" => 1061, "title" => "Premium VIP Wedding", "subtitle" => "Ultimate VIP Wedding Experience", "image" => "./images/barat2.jpg", "price" => "$30,000", "rating" => "5.0", "guests" => "200-800 Guests", "capacity" => "Any Size", "timing" => "2 Days", "location" => "Worldwide", "type" => "VIP Premium", "description" => "Ultimate VIP wedding experience with celebrity management.", "features" => ["⭐ Celebrity Management", "📋 Full Production", "🚗 Luxury Transport", "👑 VIP Concierge", "🍽️ World-Class Catering", "🎵 Professional Entertainment", "🎆 Fireworks"]],
    ["id" => 1062, "title" => "Celebrity VIP Wedding", "subtitle" => "Celebrity Style VIP Wedding", "image" => "./images/haldi1.jpg", "price" => "$25,000", "rating" => "5.0", "guests" => "200-600 Guests", "capacity" => "Any Size", "timing" => "2 Days", "location" => "Worldwide", "type" => "Celebrity VIP", "description" => "Celebrity style VIP wedding with complete luxury.", "features" => ["⭐ Celebrity Service", "📋 Full Production", "🚗 Luxury Transport", "👑 VIP Concierge", "🍽️ Premium Catering", "🎵 Live Entertainment"]],
    ["id" => 1063, "title" => "Royal VIP Wedding", "subtitle" => "Royal VIP Wedding Experience", "image" => "./images/pexels-mehmet-altintas-392989477-37188045.jpg", "price" => "$40,000", "rating" => "5.0", "guests" => "300-1000 Guests", "capacity" => "Any Size", "timing" => "3 Days", "location" => "Worldwide", "type" => "Royal VIP", "description" => "Royal VIP wedding experience with ultimate luxury.", "features" => ["👑 Royal Service", "📋 Full Production", "🚗 Luxury Transport", "👑 VIP Concierge", "🍽️ Royal Catering", "🎵 Live Entertainment", "🎆 Fireworks"]],
    ["id" => 1064, "title" => "Elite VIP Wedding", "subtitle" => "Elite VIP Wedding Package", "image" => "./images/ratepic3.jpg", "price" => "$20,000", "rating" => "4.9", "guests" => "150-500 Guests", "capacity" => "Any Size", "timing" => "Full Day", "location" => "Worldwide", "type" => "Elite VIP", "description" => "Elite VIP wedding package with complete luxury.", "features" => ["💎 Elite Service", "📋 Full Production", "🚗 Luxury Transport", "👑 VIP Concierge", "🍽️ Premium Catering", "🎵 Entertainment"]],
    ["id" => 1065, "title" => "Diamond VIP Wedding", "subtitle" => "Diamond VIP Wedding Experience", "image" => "./images/weddingpic.jpg", "price" => "$50,000", "rating" => "5.0", "guests" => "500-2000 Guests", "capacity" => "Any Size", "timing" => "4 Days", "location" => "Worldwide", "type" => "Diamond VIP", "description" => "Diamond VIP wedding experience with ultimate luxury.", "features" => ["💎 Diamond Service", "📋 Full Production", "🚗 Luxury Transport", "👑 VIP Concierge", "🍽️ World-Class Catering", "🎵 Professional Entertainment", "🎆 Fireworks", "🏨 Luxury Accommodation"]],
    ["id" => 1066, "title" => "Luxury VIP Wedding", "subtitle" => "Luxury VIP Wedding Package", "image" => "./images/v.complete.jpg", "price" => "$15,000", "rating" => "4.9", "guests" => "100-400 Guests", "capacity" => "Any Size", "timing" => "Full Day", "location" => "Worldwide", "type" => "Luxury VIP", "description" => "Luxury VIP wedding package with premium service.", "features" => ["👤 Personal Concierge", "📋 Full Planning", "🚗 Luxury Transport", "🍽️ Premium Catering", "🎵 Live Entertainment", "📸 Photography"]]
];

// ---------- 201 - Royal Stage Setup ----------
$sub_products[201] = [
    ["id" => 2011, "title" => "Royal Stage Design", "subtitle" => "Premium Royal Stage", "image" => "./images/stage1.jpg", "price" => "$2,500", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Stage", "timing" => "4 Hours Setup", "location" => "On-Site", "type" => "Stage Decor", "description" => "Premium royal stage design with premium fabrics.", "features" => ["🎭 Stage Design", "🧵 Premium Fabrics", "💡 Royal Lighting", "🖼️ Custom Backdrop", "🌸 Floral Arrangements", "🪑 VIP Seating"]],
    ["id" => 2012, "title" => "Grand Royal Stage", "subtitle" => "Grand Royal Stage Setup", "image" => "./images/stage2.jpg", "price" => "$4,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Large Stage", "timing" => "6 Hours Setup", "location" => "On-Site", "type" => "Grand Stage", "description" => "Grand royal stage setup with complete decoration.", "features" => ["🎭 Grand Stage", "🧵 Premium Fabrics", "💡 Royal Lighting", "🖼️ Custom Backdrop", "🌸 Premium Flowers", "🪑 VIP Seating"]],
    ["id" => 2013, "title" => "Elite Stage Decoration", "subtitle" => "Elite Stage Decoration", "image" => "./images/stage3.jpg", "price" => "$3,500", "rating" => "4.9", "guests" => "N/A", "capacity" => "Medium Stage", "timing" => "5 Hours Setup", "location" => "On-Site", "type" => "Elite Stage", "description" => "Elite stage decoration with premium materials.", "features" => ["🎭 Stage Design", "🧵 Elite Fabrics", "💡 Premium Lighting", "🖼️ Custom Backdrop", "🌸 Floral Arrangements", "🪑 VIP Seating"]],
    ["id" => 2014, "title" => "Royal Wedding Stage", "subtitle" => "Royal Wedding Stage Setup", "image" => "./images/stage4.jpg", "price" => "$3,000", "rating" => "4.9", "guests" => "N/A", "capacity" => "Any Stage", "timing" => "4 Hours Setup", "location" => "On-Site", "type" => "Wedding Stage", "description" => "Royal wedding stage setup with complete decoration.", "features" => ["🎭 Stage Design", "🧵 Premium Fabrics", "💡 Royal Lighting", "🖼️ Custom Backdrop", "🌸 Floral Arrangements", "🪑 VIP Seating"]],
    ["id" => 2015, "title" => "Diamond Stage", "subtitle" => "Diamond Stage Decoration", "image" => "./images/stage5.jpg", "price" => "$5,500", "rating" => "5.0", "guests" => "N/A", "capacity" => "Premium Stage", "timing" => "8 Hours Setup", "location" => "On-Site", "type" => "Diamond Stage", "description" => "Diamond stage decoration with ultimate luxury.", "features" => ["🎭 Diamond Stage", "🧵 Premium Fabrics", "💡 Luxury Lighting", "🖼️ Custom Backdrop", "🌸 Premium Flowers", "🪑 VIP Seating"]],
    ["id" => 2016, "title" => "Luxury Stage Setup", "subtitle" => "Luxury Stage Decoration", "image" => "./images/stage6.jpg", "price" => "$2,800", "rating" => "4.8", "guests" => "N/A", "capacity" => "Any Stage", "timing" => "4 Hours Setup", "location" => "On-Site", "type" => "Luxury Stage", "description" => "Luxury stage decoration with premium materials.", "features" => ["🎭 Stage Design", "🧵 Premium Fabrics", "💡 Premium Lighting", "🖼️ Custom Backdrop", "🌸 Floral Arrangements", "🪑 VIP Seating"]]
];

// ---------- 202 - Luxury Floral Decoration ----------
$sub_products[202] = [
    ["id" => 2021, "title" => "Luxury Floral Design", "subtitle" => "Premium Floral Decoration", "image" => "./images/floral1.jpg", "price" => "$2,500", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "4 Hours Setup", "location" => "On-Site", "type" => "Floral Decor", "description" => "Premium floral decoration with fresh flowers.", "features" => ["🌸 Premium Fresh Flowers", "🎨 Custom Design", "📋 Full Setup", "🪑 Table Centerpieces", "💐 Bridal Bouquet", "🌺 Stage Flowers"]],
    ["id" => 2022, "title" => "Royal Floral Arrangement", "subtitle" => "Royal Floral Decoration", "image" => "./images/floral2.jpg", "price" => "$3,500", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "5 Hours Setup", "location" => "On-Site", "type" => "Royal Floral", "description" => "Royal floral arrangement with premium flowers.", "features" => ["🌸 Royal Flowers", "🎨 Royal Design", "📋 Full Setup", "🪑 Royal Centerpieces", "💐 Bridal Bouquet", "🌺 Stage Flowers"]],
    ["id" => 2023, "title" => "Elite Floral Decor", "subtitle" => "Elite Floral Decoration", "image" => "./images/floral3.jpg", "price" => "$4,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "6 Hours Setup", "location" => "On-Site", "type" => "Elite Floral", "description" => "Elite floral decoration with exotic flowers.", "features" => ["🌸 Exotic Flowers", "🎨 Elite Design", "📋 Full Setup", "🪑 Elite Centerpieces", "💐 Bridal Bouquet", "🌺 Stage Flowers"]],
    ["id" => 2024, "title" => "Garden Floral Theme", "subtitle" => "Garden Floral Decoration", "image" => "./images/floral4.jpg", "price" => "$2,000", "rating" => "4.8", "guests" => "N/A", "capacity" => "Any Size", "timing" => "4 Hours Setup", "location" => "On-Site", "type" => "Garden Floral", "description" => "Garden floral theme with natural flowers.", "features" => ["🌸 Garden Flowers", "🎨 Natural Design", "📋 Full Setup", "🪑 Garden Centerpieces", "💐 Bridal Bouquet", "🌺 Stage Flowers"]],
    ["id" => 2025, "title" => "Diamond Floral", "subtitle" => "Diamond Floral Decoration", "image" => "./images/floral5.jpg", "price" => "$5,500", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "8 Hours Setup", "location" => "On-Site", "type" => "Diamond Floral", "description" => "Diamond floral decoration with premium flowers.", "features" => ["🌸 Premium Flowers", "🎨 Diamond Design", "📋 Full Setup", "🪑 Diamond Centerpieces", "💐 Bridal Bouquet", "🌺 Stage Flowers"]],
    ["id" => 2026, "title" => "Romantic Floral", "subtitle" => "Romantic Floral Decoration", "image" => "./images/floral6.jpg", "price" => "$2,800", "rating" => "4.9", "guests" => "N/A", "capacity" => "Any Size", "timing" => "4 Hours Setup", "location" => "On-Site", "type" => "Romantic Floral", "description" => "Romantic floral decoration with beautiful flowers.", "features" => ["🌸 Romantic Flowers", "🎨 Romantic Design", "📋 Full Setup", "🪑 Romantic Centerpieces", "💐 Bridal Bouquet", "🌺 Stage Flowers"]]
];

// ---------- 203 - Golden Entrance Decoration ----------
$sub_products[203] = [
    ["id" => 2031, "title" => "Golden Entrance", "subtitle" => "Grand Golden Entrance", "image" => "./images/enter1.jpg", "price" => "$3,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "3 Hours Setup", "location" => "On-Site", "type" => "Entrance Decor", "description" => "Grand golden entrance with premium decor.", "features" => ["🚪 Golden Gate", "🧵 Premium Drapery", "💡 Royal Lighting", "🎨 Custom Design", "🌸 Floral Welcome", "👑 VIP Guest Entry"]],
    ["id" => 2032, "title" => "Royal Golden Entrance", "subtitle" => "Royal Golden Gate Decor", "image" => "./images/enter2.jpg", "price" => "$4,500", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "4 Hours Setup", "location" => "On-Site", "type" => "Royal Entrance", "description" => "Royal golden entrance with complete decoration.", "features" => ["🚪 Royal Golden Gate", "🧵 Premium Drapery", "💡 Royal Lighting", "🎨 Custom Design", "🌸 Floral Welcome", "👑 VIP Guest Entry"]],
    ["id" => 2033, "title" => "Elite Golden Entrance", "subtitle" => "Elite Golden Gate Decor", "image" => "./images/enter3.jpg", "price" => "$5,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "5 Hours Setup", "location" => "On-Site", "type" => "Elite Entrance", "description" => "Elite golden entrance with premium materials.", "features" => ["🚪 Elite Golden Gate", "🧵 Premium Drapery", "💡 Premium Lighting", "🎨 Custom Design", "🌸 Floral Welcome", "👑 VIP Guest Entry"]],
    ["id" => 2034, "title" => "Golden Arch Entrance", "subtitle" => "Golden Arch Decoration", "image" => "./images/enter4.jpg", "price" => "$2,500", "rating" => "4.9", "guests" => "N/A", "capacity" => "Any Size", "timing" => "3 Hours Setup", "location" => "On-Site", "type" => "Golden Arch", "description" => "Golden arch entrance with beautiful flowers.", "features" => ["🚪 Golden Arch", "🌸 Floral Decor", "💡 Premium Lighting", "🎨 Custom Design", "🧵 Premium Drapery", "👑 VIP Guest Entry"]],
    ["id" => 2035, "title" => "Diamond Golden Entrance", "subtitle" => "Diamond Golden Gate Decor", "image" => "./images/enter5.jpg", "price" => "$6,500", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "6 Hours Setup", "location" => "On-Site", "type" => "Diamond Entrance", "description" => "Diamond golden entrance with ultimate luxury.", "features" => ["🚪 Diamond Golden Gate", "🧵 Premium Drapery", "💡 Luxury Lighting", "🎨 Custom Design", "🌸 Premium Flowers", "👑 VIP Guest Entry"]],
    ["id" => 2036, "title" => "Luxury Golden Entrance", "subtitle" => "Luxury Golden Gate Decor", "image" => "./images/enter6.jpg", "price" => "$3,500", "rating" => "4.9", "guests" => "N/A", "capacity" => "Any Size", "timing" => "4 Hours Setup", "location" => "On-Site", "type" => "Luxury Entrance", "description" => "Luxury golden entrance with premium decoration.", "features" => ["🚪 Luxury Golden Gate", "🧵 Premium Drapery", "💡 Premium Lighting", "🎨 Custom Design", "🌸 Floral Welcome", "👑 VIP Guest Entry"]]
];

// ---------- 204 - Crystal Theme Decoration ----------
$sub_products[204] = [
    ["id" => 2041, "title" => "Crystal Theme Decor", "subtitle" => "Elegant Crystal Decoration", "image" => "./images/crystal1.jpg", "price" => "$4,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "5 Hours Setup", "location" => "On-Site", "type" => "Crystal Decor", "description" => "Elegant crystal theme decoration with chandeliers.", "features" => ["💎 Crystal Chandeliers", "💡 Premium Lighting", "🧵 Luxury Fabrics", "📋 Complete Setup", "🪞 Mirror Decor", "💎 Crystal Centerpieces"]],
    ["id" => 2042, "title" => "Royal Crystal Theme", "subtitle" => "Royal Crystal Decoration", "image" => "./images/crystal2.jpg", "price" => "$5,500", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "6 Hours Setup", "location" => "On-Site", "type" => "Royal Crystal", "description" => "Royal crystal theme with premium crystals.", "features" => ["💎 Royal Crystal", "💡 Royal Lighting", "🧵 Luxury Fabrics", "📋 Complete Setup", "🪞 Mirror Decor", "💎 Crystal Centerpieces"]],
    ["id" => 2043, "title" => "Elite Crystal Decor", "subtitle" => "Elite Crystal Decoration", "image" => "./images/crystal3.jpg", "price" => "$6,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "7 Hours Setup", "location" => "On-Site", "type" => "Elite Crystal", "description" => "Elite crystal decoration with premium crystals.", "features" => ["💎 Elite Crystal", "💡 Premium Lighting", "🧵 Luxury Fabrics", "📋 Complete Setup", "🪞 Mirror Decor", "💎 Crystal Centerpieces"]],
    ["id" => 2044, "title" => "Diamond Crystal Theme", "subtitle" => "Diamond Crystal Decoration", "image" => "./images/crystal4.jpg", "price" => "$7,500", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "8 Hours Setup", "location" => "On-Site", "type" => "Diamond Crystal", "description" => "Diamond crystal theme with ultimate luxury.", "features" => ["💎 Diamond Crystal", "💡 Luxury Lighting", "🧵 Premium Fabrics", "📋 Complete Setup", "🪞 Mirror Decor", "💎 Crystal Centerpieces"]],
    ["id" => 2045, "title" => "Luxury Crystal Theme", "subtitle" => "Luxury Crystal Decoration", "image" => "./images/crystal5.jpg", "price" => "$4,500", "rating" => "4.9", "guests" => "N/A", "capacity" => "Any Size", "timing" => "5 Hours Setup", "location" => "On-Site", "type" => "Luxury Crystal", "description" => "Luxury crystal theme with premium crystals.", "features" => ["💎 Luxury Crystal", "💡 Premium Lighting", "🧵 Luxury Fabrics", "📋 Complete Setup", "🪞 Mirror Decor", "💎 Crystal Centerpieces"]],
    ["id" => 2046, "title" => "Crystal Palace Theme", "subtitle" => "Crystal Palace Decoration", "image" => "./images/crystal6.jpg", "price" => "$8,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "8 Hours Setup", "location" => "On-Site", "type" => "Crystal Palace", "description" => "Crystal palace theme with grand crystal displays.", "features" => ["💎 Palace Crystal", "💡 Royal Lighting", "🧵 Premium Fabrics", "📋 Complete Setup", "🪞 Mirror Decor", "💎 Crystal Centerpieces"]]
];

// ---------- 205 - Luxury Ceiling Decoration ----------
$sub_products[205] = [
    ["id" => 2051, "title" => "Luxury Ceiling Design", "subtitle" => "Premium Ceiling Decoration", "image" => "./images/cieling1.jpg", "price" => "$3,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "4 Hours Setup", "location" => "On-Site", "type" => "Ceiling Decor", "description" => "Premium ceiling decoration with LED lighting.", "features" => ["🎨 Ceiling Design", "💡 LED Lighting", "🧵 Premium Fabric", "📋 Custom Setup", "✨ Fairy Lights", "🏗️ Draping & Canopy"]],
    ["id" => 2052, "title" => "Royal Ceiling Decor", "subtitle" => "Royal Ceiling Decoration", "image" => "./images/cieling2.jpg", "price" => "$4,500", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "5 Hours Setup", "location" => "On-Site", "type" => "Royal Ceiling", "description" => "Royal ceiling decoration with premium materials.", "features" => ["🎨 Royal Design", "💡 Royal Lighting", "🧵 Premium Fabric", "📋 Custom Setup", "✨ Fairy Lights", "🏗️ Draping & Canopy"]],
    ["id" => 2053, "title" => "Elite Ceiling Decor", "subtitle" => "Elite Ceiling Decoration", "image" => "./images/cieling3.jpg", "price" => "$5,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "6 Hours Setup", "location" => "On-Site", "type" => "Elite Ceiling", "description" => "Elite ceiling decoration with premium materials.", "features" => ["🎨 Elite Design", "💡 Premium Lighting", "🧵 Premium Fabric", "📋 Custom Setup", "✨ Fairy Lights", "🏗️ Draping & Canopy"]],
    ["id" => 2054, "title" => "Diamond Ceiling", "subtitle" => "Diamond Ceiling Decoration", "image" => "./images/cieling4.jpg", "price" => "$6,500", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "7 Hours Setup", "location" => "On-Site", "type" => "Diamond Ceiling", "description" => "Diamond ceiling decoration with ultimate luxury.", "features" => ["🎨 Diamond Design", "💡 Luxury Lighting", "🧵 Premium Fabric", "📋 Custom Setup", "✨ Fairy Lights", "🏗️ Draping & Canopy"]],
    ["id" => 2055, "title" => "Luxury Canopy Ceiling", "subtitle" => "Luxury Canopy Decoration", "image" => "./images/cieling5.jpg", "price" => "$3,500", "rating" => "4.9", "guests" => "N/A", "capacity" => "Any Size", "timing" => "4 Hours Setup", "location" => "On-Site", "type" => "Canopy Ceiling", "description" => "Luxury canopy ceiling with premium fabric.", "features" => ["🎨 Canopy Design", "💡 Premium Lighting", "🧵 Premium Fabric", "📋 Custom Setup", "✨ Fairy Lights", "🏗️ Draping & Canopy"]],
    ["id" => 2056, "title" => "Royal Palace Ceiling", "subtitle" => "Royal Palace Ceiling Decoration", "image" => "./images/cieling6.jpg", "price" => "$7,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "8 Hours Setup", "location" => "On-Site", "type" => "Palace Ceiling", "description" => "Royal palace ceiling decoration with grand design.", "features" => ["🎨 Palace Design", "💡 Royal Lighting", "🧵 Premium Fabric", "📋 Custom Setup", "✨ Fairy Lights", "🏗️ Draping & Canopy"]]
];

// ---------- 206 - Complete Palace Decoration ----------
$sub_products[206] = [
    ["id" => 2061, "title" => "Palace Decoration", "subtitle" => "Complete Palace Decoration", "image" => "./images/c.vip.jpg", "price" => "$8,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "Full Day Setup", "location" => "On-Site", "type" => "Palace Decor", "description" => "Complete palace decoration with royal furniture.", "features" => ["🏰 Full Venue Styling", "🪑 Royal Furniture", "💡 Luxury Lighting", "📋 Complete Management", "🌸 Premium Floral", "🎭 Stage & Backdrop"]],
    ["id" => 2062, "title" => "Royal Palace Decor", "subtitle" => "Royal Palace Decoration", "image" => "./images/cieling1.jpg", "price" => "$10,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "Full Day Setup", "location" => "On-Site", "type" => "Royal Palace", "description" => "Royal palace decoration with premium materials.", "features" => ["🏰 Royal Palace Styling", "🪑 Royal Furniture", "💡 Royal Lighting", "📋 Complete Management", "🌸 Premium Floral", "🎭 Stage & Backdrop"]],
    ["id" => 2063, "title" => "Elite Palace Decor", "subtitle" => "Elite Palace Decoration", "image" => "./images/d.premiumvip.jpg", "price" => "$12,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "Full Day Setup", "location" => "On-Site", "type" => "Elite Palace", "description" => "Elite palace decoration with premium materials.", "features" => ["🏰 Elite Palace Styling", "🪑 Elite Furniture", "💡 Premium Lighting", "📋 Complete Management", "🌸 Premium Floral", "🎭 Stage & Backdrop"]],
    ["id" => 2064, "title" => "Diamond Palace Decor", "subtitle" => "Diamond Palace Decoration", "image" => "./images/diamondpic.jpg", "price" => "$15,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "Full Day Setup", "location" => "On-Site", "type" => "Diamond Palace", "description" => "Diamond palace decoration with ultimate luxury.", "features" => ["🏰 Diamond Palace Styling", "🪑 Diamond Furniture", "💡 Luxury Lighting", "📋 Complete Management", "🌸 Premium Floral", "🎭 Stage & Backdrop"]],
    ["id" => 2065, "title" => "Luxury Palace Decor", "subtitle" => "Luxury Palace Decoration", "image" => "./images/ds.place.jpg", "price" => "$9,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "Full Day Setup", "location" => "On-Site", "type" => "Luxury Palace", "description" => "Luxury palace decoration with premium materials.", "features" => ["🏰 Luxury Palace Styling", "🪑 Luxury Furniture", "💡 Premium Lighting", "📋 Complete Management", "🌸 Premium Floral", "🎭 Stage & Backdrop"]],
    ["id" => 2066, "title" => "Grand Palace Decor", "subtitle" => "Grand Palace Decoration", "image" => "./images/gallerypic1.jpg", "price" => "$18,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "Full Day Setup", "location" => "On-Site", "type" => "Grand Palace", "description" => "Grand palace decoration with complete styling.", "features" => ["🏰 Grand Palace Styling", "🪑 Grand Furniture", "💡 Royal Lighting", "📋 Complete Management", "🌸 Premium Floral", "🎭 Stage & Backdrop"]]
];

// ---------- 301-306: Photography & Films ----------
$sub_products[301] = [
    ["id" => 3011, "title" => "Studio Vision", "subtitle" => "Premium Studio Photography", "image" => "./images/weddingpic.jpg", "price" => "$2,500", "rating" => "4.9", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "6 Hours", "location" => "Worldwide", "type" => "Photography", "description" => "Professional studio photography with premium equipment.", "features" => ["📸 2 Photographers", "⏰ 6 Hours", "🖼️ 300+ Images", "🎨 Editing", "📖 Album", "💄 Makeup"]],
    ["id" => 3012, "title" => "Elite Films", "subtitle" => "Elite Wedding Filmmaking", "image" => "./images/walima1.jpg", "price" => "$3,800", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "8 Hours", "location" => "Worldwide", "type" => "Videography", "description" => "Elite wedding filmmaking with cinematic quality.", "features" => ["🎥 Full Videography", "🚁 Drone", "🎞️ Highlight Film", "📽️ Documentary", "🎵 Sound", "✂️ Editing"]],
    ["id" => 3013, "title" => "Royal Cinema", "subtitle" => "Royal Cinematic Experience", "image" => "./images/specialmoments.jpg", "price" => "$4,500", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "10 Hours", "location" => "Worldwide", "type" => "Cinematic", "description" => "Royal cinematic experience with 4K quality.", "features" => ["🎥 4K Videography", "🚁 Drone", "🎞️ 20-Min Highlight", "📽️ Documentary", "🎵 Soundtrack", "✂️ Editing"]],
    ["id" => 3014, "title" => "Dream Motion", "subtitle" => "Dreamy Wedding Photography", "image" => "./images/royalelte.jpg", "price" => "$3,200", "rating" => "4.8", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "8 Hours", "location" => "Worldwide", "type" => "Photography", "description" => "Dreamy wedding photography with artistic style.", "features" => ["📸 2 Photographers", "⏰ 8 Hours", "🖼️ 400+ Images", "🎨 Artistic Editing", "📖 Album", "💄 Styling"]],
    ["id" => 3015, "title" => "Luxury Lens", "subtitle" => "Luxury Photography Package", "image" => "./images/ring1.jpg", "price" => "$5,500", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "12 Hours", "location" => "Worldwide", "type" => "Luxury Photography", "description" => "Ultimate luxury photography with 3 photographers.", "features" => ["📸 3 Photographers", "⏰ 12 Hours", "🖼️ 500+ Images", "🎨 Premium Editing", "📖 Deluxe Album", "🚁 Drone"]],
    ["id" => 3016, "title" => "Wedding Stories", "subtitle" => "Storytelling Wedding Photography", "image" => "./images/ratepic1.jpg", "price" => "$4,000", "rating" => "4.9", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "10 Hours", "location" => "Worldwide", "type" => "Storytelling", "description" => "Storytelling photography that captures every emotion.", "features" => ["📸 2 Photographers", "⏰ 10 Hours", "🖼️ 450+ Images", "🎨 Story Editing", "📖 Story Album", "💄 Styling"]]
];

// ---------- 302 - Drone Coverage ----------
$sub_products[302] = [
    ["id" => 3021, "title" => "Drone Photography", "subtitle" => "Professional Drone Coverage", "image" => "./images/drone1.jpg", "price" => "$2,500", "rating" => "4.9", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "2 Hours", "location" => "Worldwide", "type" => "Drone Service", "description" => "Professional drone photography with 4K quality.", "features" => ["🚁 Drone Shoot", "🏔️ Aerial Views", "📹 4K Quality", "👨‍✈️ Pilot", "🎬 Edited", "🎞️ Cinematic Reel"]],
    ["id" => 3022, "title" => "Cinematic Drone", "subtitle" => "Cinematic Drone Coverage", "image" => "./images/drone2.jpg", "price" => "$3,500", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "3 Hours", "location" => "Worldwide", "type" => "Cinematic Drone", "description" => "Cinematic drone coverage with professional pilot.", "features" => ["🚁 Cinematic Drone", "🏔️ Aerial Views", "📹 4K Quality", "👨‍✈️ Pilot", "🎬 Cinematic Editing", "🎞️ Highlight Reel"]],
    ["id" => 3023, "title" => "Royal Drone", "subtitle" => "Royal Drone Coverage", "image" => "./images/drone3.jpg", "price" => "$4,000", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "4 Hours", "location" => "Worldwide", "type" => "Royal Drone", "description" => "Royal drone coverage with premium quality.", "features" => ["🚁 Royal Drone", "🏔️ Aerial Views", "📹 4K Quality", "👨‍✈️ Pilot", "🎬 Royal Editing", "🎞️ Royal Reel"]],
    ["id" => 3024, "title" => "Elite Drone", "subtitle" => "Elite Drone Coverage", "image" => "./images/drone4.jpg", "price" => "$4,500", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "4 Hours", "location" => "Worldwide", "type" => "Elite Drone", "description" => "Elite drone coverage with premium quality.", "features" => ["🚁 Elite Drone", "🏔️ Aerial Views", "📹 4K Quality", "👨‍✈️ Pilot", "🎬 Elite Editing", "🎞️ Elite Reel"]],
    ["id" => 3025, "title" => "Diamond Drone", "subtitle" => "Diamond Drone Coverage", "image" => "./images/drone5.jpg", "price" => "$5,500", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "5 Hours", "location" => "Worldwide", "type" => "Diamond Drone", "description" => "Diamond drone coverage with ultimate quality.", "features" => ["🚁 Diamond Drone", "🏔️ Aerial Views", "📹 4K Quality", "👨‍✈️ Pilot", "🎬 Diamond Editing", "🎞️ Diamond Reel"]],
    ["id" => 3026, "title" => "Luxury Drone", "subtitle" => "Luxury Drone Coverage", "image" => "./images/drone6.jpg", "price" => "$3,000", "rating" => "4.9", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "3 Hours", "location" => "Worldwide", "type" => "Luxury Drone", "description" => "Luxury drone coverage with premium quality.", "features" => ["🚁 Luxury Drone", "🏔️ Aerial Views", "📹 4K Quality", "👨‍✈️ Pilot", "🎬 Luxury Editing", "🎞️ Luxury Reel"]]
];

// ---------- 303 - Cinematic Film ----------
$sub_products[303] = [
    ["id" => 3031, "title" => "Cinematic Film", "subtitle" => "Professional Cinematic Film", "image" => "./images/film6.jpg", "price" => "$4,000", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "8 Hours", "location" => "Worldwide", "type" => "Cinematic", "description" => "Professional cinematic film with full videography.", "features" => ["🎥 Full Videography", "🎬 Cinematic Style", "✂️ Editing", "🎞️ Highlight Film", "📽️ Documentary", "🎵 Sound"]],
    ["id" => 3032, "title" => "Royal Cinematic", "subtitle" => "Royal Cinematic Film", "image" => "./images/film1.jpg", "price" => "$5,500", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "10 Hours", "location" => "Worldwide", "type" => "Royal Cinematic", "description" => "Royal cinematic film with premium quality.", "features" => ["🎥 Full Videography", "🎬 Royal Style", "✂️ Editing", "🎞️ Royal Highlight", "📽️ Documentary", "🎵 Royal Sound"]],
    ["id" => 3033, "title" => "Elite Cinematic", "subtitle" => "Elite Cinematic Film", "image" => "./images/film2.jpg", "price" => "$6,000", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "10 Hours", "location" => "Worldwide", "type" => "Elite Cinematic", "description" => "Elite cinematic film with premium quality.", "features" => ["🎥 Full Videography", "🎬 Elite Style", "✂️ Editing", "🎞️ Elite Highlight", "📽️ Documentary", "🎵 Elite Sound"]],
    ["id" => 3034, "title" => "Diamond Cinematic", "subtitle" => "Diamond Cinematic Film", "image" => "./images/film3.jpg", "price" => "$7,500", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "12 Hours", "location" => "Worldwide", "type" => "Diamond Cinematic", "description" => "Diamond cinematic film with ultimate quality.", "features" => ["🎥 Full Videography", "🎬 Diamond Style", "✂️ Editing", "🎞️ Diamond Highlight", "📽️ Documentary", "🎵 Diamond Sound"]],
    ["id" => 3035, "title" => "Luxury Cinematic", "subtitle" => "Luxury Cinematic Film", "image" => "./images/film4.jpg", "price" => "$4,500", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "8 Hours", "location" => "Worldwide", "type" => "Luxury Cinematic", "description" => "Luxury cinematic film with premium quality.", "features" => ["🎥 Full Videography", "🎬 Luxury Style", "✂️ Editing", "🎞️ Luxury Highlight", "📽️ Documentary", "🎵 Luxury Sound"]],
    ["id" => 3036, "title" => "Premium Cinematic", "subtitle" => "Premium Cinematic Film", "image" => "./images/film5.jpg", "price" => "$5,000", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "8 Hours", "location" => "Worldwide", "type" => "Premium Cinematic", "description" => "Premium cinematic film with complete videography.", "features" => ["🎥 Full Videography", "🎬 Premium Style", "✂️ Editing", "🎞️ Premium Highlight", "📽️ Documentary", "🎵 Premium Sound"]]
];

// ---------- 304 - Pre Wedding Shoot ----------
$sub_products[304] = [
    ["id" => 3041, "title" => "Pre Wedding Shoot", "subtitle" => "Beautiful Pre-Wedding Shoot", "image" => "./images/turkey.jpg", "price" => "$2,500", "rating" => "4.9", "guests" => "2-20 Guests", "capacity" => "Small Groups", "timing" => "4 Hours", "location" => "Worldwide", "type" => "Pre-Wedding", "description" => "Beautiful pre-wedding shoot with multiple locations.", "features" => ["📍 Multiple Locations", "💄 Styling", "📸 Full Coverage", "📖 Album", "💇 Makeup", "🖼️ 150+ Images"]],
    ["id" => 3042, "title" => "Royal Pre Wedding", "subtitle" => "Royal Pre-Wedding Shoot", "image" => "./images/ratepic3.jpg", "price" => "$3,500", "rating" => "5.0", "guests" => "2-30 Guests", "capacity" => "Small Groups", "timing" => "6 Hours", "location" => "Worldwide", "type" => "Royal Pre-Wedding", "description" => "Royal pre-wedding shoot with premium locations.", "features" => ["📍 Royal Locations", "💄 Royal Styling", "📸 Full Coverage", "📖 Royal Album", "💇 Makeup", "🖼️ 200+ Images"]],
    ["id" => 3043, "title" => "Elite Pre Wedding", "subtitle" => "Elite Pre-Wedding Shoot", "image" => "./images/ratepic2.jpg", "price" => "$4,000", "rating" => "5.0", "guests" => "2-40 Guests", "capacity" => "Small Groups", "timing" => "6 Hours", "location" => "Worldwide", "type" => "Elite Pre-Wedding", "description" => "Elite pre-wedding shoot with premium locations.", "features" => ["📍 Elite Locations", "💄 Elite Styling", "📸 Full Coverage", "📖 Elite Album", "💇 Makeup", "🖼️ 250+ Images"]],
    ["id" => 3044, "title" => "Diamond Pre Wedding", "subtitle" => "Diamond Pre-Wedding Shoot", "image" => "./images/premium.jpg", "price" => "$5,000", "rating" => "5.0", "guests" => "2-50 Guests", "capacity" => "Small Groups", "timing" => "8 Hours", "location" => "Worldwide", "type" => "Diamond Pre-Wedding", "description" => "Diamond pre-wedding shoot with ultimate luxury.", "features" => ["📍 Diamond Locations", "💄 Diamond Styling", "📸 Full Coverage", "📖 Diamond Album", "💇 Makeup", "🖼️ 300+ Images"]],
    ["id" => 3045, "title" => "Luxury Pre Wedding", "subtitle" => "Luxury Pre-Wedding Shoot", "image" => "./images/photography.jpg", "price" => "$3,000", "rating" => "4.9", "guests" => "2-25 Guests", "capacity" => "Small Groups", "timing" => "5 Hours", "location" => "Worldwide", "type" => "Luxury Pre-Wedding", "description" => "Luxury pre-wedding shoot with premium locations.", "features" => ["📍 Luxury Locations", "💄 Luxury Styling", "📸 Full Coverage", "📖 Luxury Album", "💇 Makeup", "🖼️ 200+ Images"]],
    ["id" => 3046, "title" => "Premium Pre Wedding", "subtitle" => "Premium Pre-Wedding Shoot", "image" => "./images/celebrity.jpg", "price" => "$2,800", "rating" => "4.8", "guests" => "2-15 Guests", "capacity" => "Small Groups", "timing" => "4 Hours", "location" => "Worldwide", "type" => "Premium Pre-Wedding", "description" => "Premium pre-wedding shoot with beautiful locations.", "features" => ["📍 Premium Locations", "💄 Professional Styling", "📸 Full Coverage", "📖 Premium Album", "💇 Makeup", "🖼️ 180+ Images"]]
];

// ---------- 305 - Luxury Album ----------
$sub_products[305] = [
    ["id" => 3051, "title" => "Luxury Album", "subtitle" => "Premium Wedding Album", "image" => "./images/album1.jpg", "price" => "$1,500", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "2-3 Weeks Delivery", "location" => "Worldwide", "type" => "Album Service", "description" => "Premium wedding album with luxury cover.", "features" => ["📖 Luxury Cover", "📄 Premium Pages", "🎨 Custom Design", "🖨️ High Quality", "🎁 Deluxe Packaging", "💻 Digital Copy"]],
    ["id" => 3052, "title" => "Royal Album", "subtitle" => "Royal Wedding Album", "image" => "./images/album2.jpg", "price" => "$2,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "3-4 Weeks Delivery", "location" => "Worldwide", "type" => "Royal Album", "description" => "Royal wedding album with premium materials.", "features" => ["📖 Royal Cover", "📄 Premium Pages", "🎨 Royal Design", "🖨️ High Quality", "🎁 Deluxe Packaging", "💻 Digital Copy"]],
    ["id" => 3053, "title" => "Elite Album", "subtitle" => "Elite Wedding Album", "image" => "./images/album3.jpg", "price" => "$2,500", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "3-4 Weeks Delivery", "location" => "Worldwide", "type" => "Elite Album", "description" => "Elite wedding album with premium materials.", "features" => ["📖 Elite Cover", "📄 Premium Pages", "🎨 Elite Design", "🖨️ High Quality", "🎁 Deluxe Packaging", "💻 Digital Copy"]],
    ["id" => 3054, "title" => "Diamond Album", "subtitle" => "Diamond Wedding Album", "image" => "./images/album4.jpg", "price" => "$3,000", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "4-5 Weeks Delivery", "location" => "Worldwide", "type" => "Diamond Album", "description" => "Diamond wedding album with ultimate luxury.", "features" => ["📖 Diamond Cover", "📄 Premium Pages", "🎨 Diamond Design", "🖨️ High Quality", "🎁 Deluxe Packaging", "💻 Digital Copy"]],
    ["id" => 3055, "title" => "Premium Album", "subtitle" => "Premium Wedding Album", "image" => "./images/album5.jpg", "price" => "$1,800", "rating" => "4.9", "guests" => "N/A", "capacity" => "Any Size", "timing" => "2-3 Weeks Delivery", "location" => "Worldwide", "type" => "Premium Album", "description" => "Premium wedding album with high quality print.", "features" => ["📖 Premium Cover", "📄 Premium Pages", "🎨 Custom Design", "🖨️ High Quality", "🎁 Deluxe Packaging", "💻 Digital Copy"]],
    ["id" => 3056, "title" => "Grand Album", "subtitle" => "Grand Wedding Album", "image" => "./images/album6.jpg", "price" => "$3,500", "rating" => "5.0", "guests" => "N/A", "capacity" => "Any Size", "timing" => "4-5 Weeks Delivery", "location" => "Worldwide", "type" => "Grand Album", "description" => "Grand wedding album with ultimate luxury.", "features" => ["📖 Grand Cover", "📄 Premium Pages", "🎨 Grand Design", "🖨️ High Quality", "🎁 Deluxe Packaging", "💻 Digital Copy"]]
];

// ---------- 306 - Complete Premium Package ----------
$sub_products[306] = [
    ["id" => 3061, "title" => "Complete Premium", "subtitle" => "Complete Premium Package", "image" => "./images/v.complete.jpg", "price" => "$8,000", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "12 Hours", "location" => "Worldwide", "type" => "Complete Package", "description" => "Complete premium package with 12 hours coverage.", "features" => ["⏰ 12 Hours", "📸 3 Photographers", "🎥 Full Videography", "🚁 Drone", "📖 Album", "🎞️ Highlight Film", "🖼️ All Images"]],
    ["id" => 3062, "title" => "Royal Complete", "subtitle" => "Royal Complete Package", "image" => "./images/stage3.jpg", "price" => "$10,000", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "14 Hours", "location" => "Worldwide", "type" => "Royal Complete", "description" => "Royal complete package with premium coverage.", "features" => ["⏰ 14 Hours", "📸 4 Photographers", "🎥 Full Videography", "🚁 Drone", "📖 Royal Album", "🎞️ Highlight Film", "🖼️ All Images"]],
    ["id" => 3063, "title" => "Elite Complete", "subtitle" => "Elite Complete Package", "image" => "./images/stage6.jpg", "price" => "$12,000", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "16 Hours", "location" => "Worldwide", "type" => "Elite Complete", "description" => "Elite complete package with premium coverage.", "features" => ["⏰ 16 Hours", "📸 5 Photographers", "🎥 Full Videography", "🚁 Drone", "📖 Elite Album", "🎞️ Highlight Film", "🖼️ All Images"]],
    ["id" => 3064, "title" => "Diamond Complete", "subtitle" => "Diamond Complete Package", "image" => "./images/ds.completedecor.jpg", "price" => "$15,000", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "20 Hours", "location" => "Worldwide", "type" => "Diamond Complete", "description" => "Diamond complete package with ultimate luxury.", "features" => ["⏰ 20 Hours", "📸 6 Photographers", "🎥 Full Videography", "🚁 Drone", "📖 Diamond Album", "🎞️ Highlight Film", "🖼️ All Images"]],
    ["id" => 3065, "title" => "Luxury Complete", "subtitle" => "Luxury Complete Package", "image" => "./images/stage5.jpg", "price" => "$9,000", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "14 Hours", "location" => "Worldwide", "type" => "Luxury Complete", "description" => "Luxury complete package with premium coverage.", "features" => ["⏰ 14 Hours", "📸 4 Photographers", "🎥 Full Videography", "🚁 Drone", "📖 Luxury Album", "🎞️ Highlight Film", "🖼️ All Images"]],
    ["id" => 3066, "title" => "Grand Complete", "subtitle" => "Grand Complete Package", "image" => "./images/compvenue1.jpg", "price" => "$18,000", "rating" => "5.0", "guests" => "Unlimited", "capacity" => "Any Size", "timing" => "24 Hours", "location" => "Worldwide", "type" => "Grand Complete", "description" => "Grand complete package with ultimate luxury.", "features" => ["⏰ 24 Hours", "📸 8 Photographers", "🎥 Full Videography", "🚁 Drone", "📖 Grand Album", "🎞️ Highlight Film", "🖼️ All Images"]]
];

// ---------- 401 - Silver Buffet ----------
$sub_products[401] = [
    ["id" => 4011, "title" => "Silver Buffet", "subtitle" => "Classic Wedding Buffet", "image" => "./images/silverc1.jpg", "price" => "PKR 2,000/head", "rating" => "4.5", "guests" => "50-1000 Guests", "capacity" => "Any Size", "timing" => "3-5 Hours", "location" => "On-Site", "type" => "Buffet Service", "description" => "Classic buffet with delicious options for your wedding.", "features" => ["🍽️ 5 Main Dishes", "🍰 2 Desserts", "🥤 Beverages", "👨‍🍳 Standard Service", "🍛 Pakistani Cuisine", "🥗 Salad Bar"]],
    ["id" => 4012, "title" => "Silver Plus Buffet", "subtitle" => "Premium Silver Buffet", "image" => "./images/silverc2.jpg", "price" => "PKR 2,500/head", "rating" => "4.6", "guests" => "50-1000 Guests", "capacity" => "Any Size", "timing" => "3-5 Hours", "location" => "On-Site", "type" => "Buffet Service", "description" => "Premium silver buffet with more variety.", "features" => ["🍽️ 7 Main Dishes", "🍰 3 Desserts", "🥤 Beverages", "👨‍🍳 Standard Service", "🍛 Pakistani + Continental", "🥗 Salad Bar"]],
    ["id" => 4013, "title" => "Family Buffet", "subtitle" => "Family Style Buffet", "image" => "./images/silverc3.jpg", "price" => "PKR 3,000/head", "rating" => "4.7", "guests" => "50-800 Guests", "capacity" => "Any Size", "timing" => "3-5 Hours", "location" => "On-Site", "type" => "Family Buffet", "description" => "Family style buffet perfect for intimate weddings.", "features" => ["🍽️ 8 Main Dishes", "🍰 4 Desserts", "🥤 Beverages", "👨‍🍳 Family Service", "🍛 Desi Cuisine", "🥗 Fresh Salads"]],
    ["id" => 4014, "title" => "Standard Catering", "subtitle" => "Standard Wedding Catering", "image" => "./images/silverc4.jpg", "price" => "PKR 2,200/head", "rating" => "4.5", "guests" => "100-1000 Guests", "capacity" => "Any Size", "timing" => "4-6 Hours", "location" => "On-Site", "type" => "Catering", "description" => "Standard wedding catering with complete service.", "features" => ["🍽️ 6 Main Dishes", "🍰 3 Desserts", "🥤 Soft Drinks", "👨‍🍳 Buffet Setup", "🍛 Standard Menu", "🥗 Salad Counter"]],
    ["id" => 4015, "title" => "Classic Dinner", "subtitle" => "Classic Dinner Service", "image" => "./images/silverc5.jpg", "price" => "PKR 2,800/head", "rating" => "4.6", "guests" => "50-1000 Guests", "capacity" => "Any Size", "timing" => "4-6 Hours", "location" => "On-Site", "type" => "Dinner Service", "description" => "Classic dinner service with elegant presentation.", "features" => ["🍽️ 7 Main Dishes", "🍰 3 Desserts", "🥤 Beverages", "👨‍🍳 Waiter Service", "🍛 Classic Menu", "🥗 Salad Bar"]],
    ["id" => 4016, "title" => "Essential Catering", "subtitle" => "Essential Wedding Catering", "image" => "./images/silverc6.jpg", "price" => "PKR 2,000/head", "rating" => "4.4", "guests" => "50-800 Guests", "capacity" => "Any Size", "timing" => "3-5 Hours", "location" => "On-Site", "type" => "Catering", "description" => "Essential catering package for budget weddings.", "features" => ["🍽️ 5 Main Dishes", "🍰 2 Desserts", "🥤 Soft Drinks", "👨‍🍳 Buffet Setup", "🍛 Basic Menu", "🥗 Simple Salad"]]
];

// ---------- 402 - Gold Buffet ----------
$sub_products[402] = [
    ["id" => 4021, "title" => "Gold Buffet", "subtitle" => "Premium Gold Buffet", "image" => "./images/gold1.jpg", "price" => "PKR 3,500/head", "rating" => "4.7", "guests" => "50-1000 Guests", "capacity" => "Any Size", "timing" => "3-5 Hours", "location" => "On-Site", "type" => "Buffet Service", "description" => "Premium buffet with gourmet dishes.", "features" => ["🍽️ 8 Main Dishes", "🍰 4 Desserts", "🥤 Mocktails", "👨‍🍳 Premium Service", "🍛 Continental + Desi", "🥗 Live Salad Bar"]],
    ["id" => 4022, "title" => "Gold Plus Buffet", "subtitle" => "Gold Plus Buffet", "image" => "./images/gold2.jpg", "price" => "PKR 4,000/head", "rating" => "4.8", "guests" => "50-1000 Guests", "capacity" => "Any Size", "timing" => "3-5 Hours", "location" => "On-Site", "type" => "Buffet Service", "description" => "Gold Plus buffet with extra variety.", "features" => ["🍽️ 10 Main Dishes", "🍰 5 Desserts", "🥤 Mocktails + Juices", "👨‍🍳 Premium Service", "🍛 Multi-Cuisine", "🥗 Live Salad Bar"]],
    ["id" => 4023, "title" => "Golden Feast", "subtitle" => "Golden Feast Buffet", "image" => "./images/gold3.jpg", "price" => "PKR 4,500/head", "rating" => "4.8", "guests" => "50-1000 Guests", "capacity" => "Any Size", "timing" => "4-6 Hours", "location" => "On-Site", "type" => "Grand Buffet", "description" => "Golden feast with grand presentation.", "features" => ["🍽️ 12 Main Dishes", "🍰 6 Desserts", "🥤 Premium Beverages", "👨‍🍳 Waiter Service", "🍛 International Cuisine", "🥗 Gourmet Salads"]],
    ["id" => 4024, "title" => "Gold Dinner", "subtitle" => "Gold Dinner Service", "image" => "./images/gold4.jpg", "price" => "PKR 3,800/head", "rating" => "4.7", "guests" => "50-1000 Guests", "capacity" => "Any Size", "timing" => "4-6 Hours", "location" => "On-Site", "type" => "Dinner Service", "description" => "Elegant gold dinner service.", "features" => ["🍽️ 9 Main Dishes", "🍰 4 Desserts", "🥤 Premium Drinks", "👨‍🍳 Table Service", "🍛 Fine Dining", "🥗 Salad Bar"]],
    ["id" => 4025, "title" => "Gold Standard", "subtitle" => "Gold Standard Catering", "image" => "./images/gold5.jpg", "price" => "PKR 3,500/head", "rating" => "4.7", "guests" => "100-1500 Guests", "capacity" => "Any Size", "timing" => "4-6 Hours", "location" => "On-Site", "type" => "Catering", "description" => "Gold standard catering for premium weddings.", "features" => ["🍽️ 8 Main Dishes", "🍰 4 Desserts", "🥤 Beverages", "👨‍🍳 Professional Service", "🍛 Premium Menu", "🥗 Salad Bar"]],
    ["id" => 4026, "title" => "Gold Premium", "subtitle" => "Gold Premium Buffet", "image" => "./images/gold6.jpg", "price" => "PKR 4,200/head", "rating" => "4.8", "guests" => "100-1500 Guests", "capacity" => "Any Size", "timing" => "4-7 Hours", "location" => "On-Site", "type" => "Premium Buffet", "description" => "Gold premium buffet with exclusive dishes.", "features" => ["🍽️ 11 Main Dishes", "🍰 5 Desserts", "🥤 Premium Mocktails", "👨‍🍳 Full Service", "🍛 Fusion Cuisine", "🥗 Live Counters"]]
];

// ---------- 403 - Royal Buffet ----------
$sub_products[403] = [
    ["id" => 4031, "title" => "Royal Buffet", "subtitle" => "Royal Dining Experience", "image" => "./images/royal1.jpg", "price" => "PKR 5,000/head", "rating" => "4.9", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "4-6 Hours", "location" => "On-Site", "type" => "Royal Buffet", "description" => "Royal dining experience with live stations.", "features" => ["🍽️ 10 Main Dishes", "🍰 6 Desserts", "🥤 Welcome Drinks", "👨‍🍳 Royal Service", "🍛 Live Stations", "🥗 Gourmet Salads"]],
    ["id" => 4032, "title" => "Royal Feast", "subtitle" => "Grand Royal Feast", "image" => "./images/royal2.jpg", "price" => "PKR 6,000/head", "rating" => "5.0", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "5-7 Hours", "location" => "On-Site", "type" => "Royal Feast", "description" => "Grand royal feast with multiple live counters.", "features" => ["🍽️ 14 Main Dishes", "🍰 8 Desserts", "🥤 Premium Beverages", "👨‍🍳 Butler Service", "🍛 International Cuisine", "🥗 Live Counters"]],
    ["id" => 4033, "title" => "Royal Dinner", "subtitle" => "Royal Dinner Service", "image" => "./images/royal3.jpg", "price" => "PKR 5,500/head", "rating" => "4.9", "guests" => "100-1500 Guests", "capacity" => "Any Size", "timing" => "5-7 Hours", "location" => "On-Site", "type" => "Royal Dinner", "description" => "Royal dinner service with white-glove treatment.", "features" => ["🍽️ 12 Main Dishes", "🍰 6 Desserts", "🥤 Premium Drinks", "👨‍🍳 White Glove Service", "🍛 Royal Menu", "🥗 Gourmet Salads"]],
    ["id" => 4034, "title" => "Maharaja Buffet", "subtitle" => "Maharaja Style Buffet", "image" => "./images/royal4.jpg", "price" => "PKR 6,500/head", "rating" => "5.0", "guests" => "150-2000 Guests", "capacity" => "Any Size", "timing" => "5-7 Hours", "location" => "On-Site", "type" => "Maharaja Buffet", "description" => "Maharaja style buffet fit for royalty.", "features" => ["🍽️ 15 Main Dishes", "🍰 8 Desserts", "🥤 Royal Beverages", "👨‍🍳 Royal Service", "🍛 Mughlai Cuisine", "🥗 Live Counters"]],
    ["id" => 4035, "title" => "Royal Crown", "subtitle" => "Royal Crown Catering", "image" => "./images/royal5.jpg", "price" => "PKR 5,800/head", "rating" => "4.9", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "5-7 Hours", "location" => "On-Site", "type" => "Royal Catering", "description" => "Royal crown catering with premium service.", "features" => ["🍽️ 12 Main Dishes", "🍰 7 Desserts", "🥤 Premium Beverages", "👨‍🍳 Crown Service", "🍛 Royal Cuisine", "🥗 Salad Bar"]],
    ["id" => 4036, "title" => "Royal Grand", "subtitle" => "Royal Grand Buffet", "image" => "./images/royal6.jpg", "price" => "PKR 7,000/head", "rating" => "5.0", "guests" => "150-2500 Guests", "capacity" => "Any Size", "timing" => "6-8 Hours", "location" => "On-Site", "type" => "Grand Royal Buffet", "description" => "Royal grand buffet for the most luxurious weddings.", "features" => ["🍽️ 16 Main Dishes", "🍰 10 Desserts", "🥤 Premium Beverages", "👨‍🍳 Royal Butler Service", "🍛 World Cuisine", "🥗 Live Counters"]]
];

// ---------- 404 - VIP Buffet ----------
$sub_products[404] = [
    ["id" => 4041, "title" => "VIP Buffet", "subtitle" => "VIP Dining Experience", "image" => "./images/vip1.jpg", "price" => "PKR 7,000/head", "rating" => "4.8", "guests" => "50-500 Guests", "capacity" => "Any Size", "timing" => "4-6 Hours", "location" => "On-Site", "type" => "VIP Buffet", "description" => "VIP dining with exclusive menu.", "features" => ["🍽️ Exclusive Menu", "🍰 Premium Desserts", "🥤 Imported Beverages", "👨‍🍳 Personal Chef", "🍛 Gourmet Cuisine", "🥗 Premium Salads"]],
    ["id" => 4042, "title" => "VIP Platinum", "subtitle" => "VIP Platinum Dining", "image" => "./images/vip2.jpg", "price" => "PKR 8,500/head", "rating" => "5.0", "guests" => "50-500 Guests", "capacity" => "Any Size", "timing" => "5-7 Hours", "location" => "On-Site", "type" => "Platinum Dining", "description" => "VIP platinum dining with 5-star service.", "features" => ["🍽️ 12 Main Dishes", "🍰 8 Premium Desserts", "🥤 Imported Beverages", "👨‍🍳 Personal Chef", "🍛 5-Star Cuisine", "🥗 Gourmet Salads"]],
    ["id" => 4043, "title" => "VIP Gold", "subtitle" => "VIP Gold Dining", "image" => "./images/vip3.jpg", "price" => "PKR 9,000/head", "rating" => "5.0", "guests" => "50-400 Guests", "capacity" => "Any Size", "timing" => "5-7 Hours", "location" => "On-Site", "type" => "VIP Gold", "description" => "VIP gold dining with exclusive privileges.", "features" => ["🍽️ 14 Main Dishes", "🍰 9 Desserts", "🥤 Premium Beverages", "👨‍🍳 Master Chef", "🍛 Fusion Cuisine", "🥗 Live Counters"]],
    ["id" => 4044, "title" => "VIP Diamond", "subtitle" => "VIP Diamond Dining", "image" => "./images/vip4.jpg", "price" => "PKR 10,000/head", "rating" => "5.0", "guests" => "50-300 Guests", "capacity" => "Any Size", "timing" => "5-8 Hours", "location" => "On-Site", "type" => "VIP Diamond", "description" => "VIP diamond dining with ultimate luxury.", "features" => ["🍽️ 16 Main Dishes", "🍰 10 Desserts", "🥤 Premium Beverages", "👨‍🍳 Celebrity Chef", "🍛 World Cuisine", "🥗 Live Counters"]],
    ["id" => 4045, "title" => "VIP Elite", "subtitle" => "VIP Elite Dining", "image" => "./images/vip5.jpg", "price" => "PKR 8,000/head", "rating" => "4.9", "guests" => "50-500 Guests", "capacity" => "Any Size", "timing" => "5-7 Hours", "location" => "On-Site", "type" => "VIP Elite", "description" => "VIP elite dining with exclusive menu.", "features" => ["🍽️ 12 Main Dishes", "🍰 8 Desserts", "🥤 Premium Beverages", "👨‍🍳 Elite Chef", "🍛 Elite Cuisine", "🥗 Premium Salads"]],
    ["id" => 4046, "title" => "VIP Royal", "subtitle" => "VIP Royal Dining", "image" => "./images/vip6.jpg", "price" => "PKR 12,000/head", "rating" => "5.0", "guests" => "50-300 Guests", "capacity" => "Any Size", "timing" => "6-8 Hours", "location" => "On-Site", "type" => "VIP Royal", "description" => "VIP royal dining with royal treatment.", "features" => ["🍽️ 18 Main Dishes", "🍰 12 Desserts", "🥤 Champagne Service", "👨‍🍳 Royal Chef", "🍛 Royal Cuisine", "🥗 Live Counters"]]
];

// ---------- 405 - Dessert Station ----------
$sub_products[405] = [
    ["id" => 4051, "title" => "Dessert Station", "subtitle" => "Luxury Dessert Station", "image" => "./images/desert1.jpg", "price" => "PKR 1,500/head", "rating" => "4.6", "guests" => "50-1000 Guests", "capacity" => "Any Size", "timing" => "3-5 Hours", "location" => "On-Site", "type" => "Dessert Service", "description" => "Luxury dessert station with 10+ desserts.", "features" => ["🍰 10+ Desserts", "🍫 Chocolate Fountain", "🎂 Custom Cake", "🍦 Ice Cream Bar", "🥧 Live Waffles", "🍮 Premium Service"]],
    ["id" => 4052, "title" => "Sweet Corner", "subtitle" => "Sweet Corner Dessert", "image" => "./images/desert2.jpg", "price" => "PKR 2,000/head", "rating" => "4.7", "guests" => "50-1000 Guests", "capacity" => "Any Size", "timing" => "3-5 Hours", "location" => "On-Site", "type" => "Sweet Corner", "description" => "Sweet corner with premium desserts.", "features" => ["🍰 15+ Desserts", "🍫 Chocolate Fountain", "🎂 3 Tier Cake", "🍦 Ice Cream Bar", "🥧 Live Waffles", "🍮 Premium Service"]],
    ["id" => 4053, "title" => "Chocolate Fountain", "subtitle" => "Chocolate Fountain Station", "image" => "./images/desert3.jpg", "price" => "PKR 2,500/head", "rating" => "4.8", "guests" => "50-800 Guests", "capacity" => "Any Size", "timing" => "3-5 Hours", "location" => "On-Site", "type" => "Chocolate Station", "description" => "Chocolate fountain station with dips.", "features" => ["🍫 5 Tier Fountain", "🍓 Fresh Fruits", "🍪 Cookies & Marshmallows", "🍰 Brownies", "🥧 Churros", "🍮 Premium Setup"]],
    ["id" => 4054, "title" => "Ice Cream Bar", "subtitle" => "Premium Ice Cream Bar", "image" => "./images/desert4.jpg", "price" => "PKR 1,800/head", "rating" => "4.6", "guests" => "50-1000 Guests", "capacity" => "Any Size", "timing" => "3-5 Hours", "location" => "On-Site", "type" => "Ice Cream Bar", "description" => "Premium ice cream bar with 20+ flavors.", "features" => ["🍦 20+ Flavors", "🍨 Sundae Station", "🍧 Toppings Bar", "🍰 Waffle Cones", "🥤 Milkshakes", "🍮 Premium Service"]],
    ["id" => 4055, "title" => "Cake Studio", "subtitle" => "Custom Cake Studio", "image" => "./images/desert5.jpg", "price" => "PKR 3,000/head", "rating" => "4.9", "guests" => "50-500 Guests", "capacity" => "Any Size", "timing" => "3-5 Hours", "location" => "On-Site", "type" => "Cake Studio", "description" => "Custom cake studio with designer cakes.", "features" => ["🎂 Custom Designer Cake", "🍰 10+ Cakes", "🧁 Cupcake Tower", "🍪 Macarons", "🍮 Dessert Shots", "🍫 Premium Setup"]],
    ["id" => 4056, "title" => "Grand Dessert", "subtitle" => "Grand Dessert Station", "image" => "./images/desert6.jpg", "price" => "PKR 4,000/head", "rating" => "5.0", "guests" => "100-1000 Guests", "capacity" => "Any Size", "timing" => "4-6 Hours", "location" => "On-Site", "type" => "Grand Dessert", "description" => "Grand dessert station with everything.", "features" => ["🍰 25+ Desserts", "🍫 7 Tier Fountain", "🎂 5 Tier Cake", "🍦 Ice Cream Bar", "🥧 Live Stations", "🍮 Royal Setup"]]
];

// ---------- 406 - Luxury Complete Catering ----------
$sub_products[406] = [
    ["id" => 4061, "title" => "Luxury Complete", "subtitle" => "Complete Luxury Catering", "image" => "./images/royal5.jpg", "price" => "PKR 12,000/head", "rating" => "5.0", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "Full Day", "location" => "On-Site", "type" => "Complete Catering", "description" => "Complete luxury catering package.", "features" => ["🍽️ Full Menu", "🍰 All Desserts", "🥤 Premium Drinks", "👨‍🍳 Full Service", "🍛 All Cuisines", "🎂 Cake Included", "🥗 Salad Bar", "🎪 Event Coordination"]],
    ["id" => 4062, "title" => "Mega Catering", "subtitle" => "Mega Wedding Catering", "image" => "./images/royal6.jpg", "price" => "PKR 15,000/head", "rating" => "5.0", "guests" => "200-3000 Guests", "capacity" => "Any Size", "timing" => "Full Day +", "location" => "On-Site", "type" => "Mega Catering", "description" => "Mega wedding catering with everything.", "features" => ["🍽️ 20+ Dishes", "🍰 15+ Desserts", "🥤 Premium Drinks", "👨‍🍳 Master Chef", "🍛 World Cuisine", "🎂 Custom Cake", "🥗 Live Counters", "🎪 Full Coordination"]],
    ["id" => 4063, "title" => "Royal Catering", "subtitle" => "Royal Complete Catering", "image" => "./images/royal4.jpg", "price" => "PKR 18,000/head", "rating" => "5.0", "guests" => "150-2000 Guests", "capacity" => "Any Size", "timing" => "Full Day +", "location" => "On-Site", "type" => "Royal Catering", "description" => "Royal complete catering with royal treatment.", "features" => ["🍽️ 25+ Dishes", "🍰 20+ Desserts", "🥤 Champagne", "👨‍🍳 Royal Chef", "🍛 Royal Cuisine", "🎂 Royal Cake", "🥗 Live Counters", "🎪 Butler Service"]],
    ["id" => 4064, "title" => "Premium Catering", "subtitle" => "Premium Complete Catering", "image" => "./images/vip4.jpg", "price" => "PKR 14,000/head", "rating" => "5.0", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "Full Day", "location" => "On-Site", "type" => "Premium Catering", "description" => "Premium complete catering with all services.", "features" => ["🍽️ 18+ Dishes", "🍰 12+ Desserts", "🥤 Premium Drinks", "👨‍🍳 Professional Chef", "🍛 Multi-Cuisine", "🎂 Custom Cake", "🥗 Live Counters", "🎪 Full Service"]],
    ["id" => 4065, "title" => "Grand Catering", "subtitle" => "Grand Complete Catering", "image" => "./images/vip6.jpg", "price" => "PKR 20,000/head", "rating" => "5.0", "guests" => "200-5000 Guests", "capacity" => "Any Size", "timing" => "Full Day +", "location" => "On-Site", "type" => "Grand Catering", "description" => "Grand complete catering for mega weddings.", "features" => ["🍽️ 30+ Dishes", "🍰 25+ Desserts", "🥤 Premium Bar", "👨‍🍳 Celebrity Chef", "🍛 World Cuisine", "🎂 5 Tier Cake", "🥗 Live Counters", "🎪 Full Management"]],
    ["id" => 4066, "title" => "Elite Catering", "subtitle" => "Elite Complete Catering", "image" => "./images/vip5.jpg", "price" => "PKR 25,000/head", "rating" => "5.0", "guests" => "100-1000 Guests", "capacity" => "Any Size", "timing" => "Full Day +", "location" => "On-Site", "type" => "Elite Catering", "description" => "Elite complete catering with celebrity chef.", "features" => ["🍽️ Custom Menu", "🍰 Custom Desserts", "🥤 Premium Bar", "👨‍🍳 Celebrity Chef", "🍛 Custom Cuisine", "🎂 Designer Cake", "🥗 Live Counters", "🎪 Personal Butler"]]
];

// ---------- 501 - Live Band ----------
$sub_products[501] = [
    ["id" => 5011, "title" => "Live Band", "subtitle" => "Professional Live Band", "image" => "./images/band1.jpg", "price" => "PKR 80,000", "rating" => "4.8", "guests" => "50-2000 Guests", "capacity" => "Any Size", "timing" => "4 Hours", "location" => "On-Site", "type" => "Live Music", "description" => "Professional live band performance.", "features" => ["🎸 4 Hours Performance", "🎤 Professional Musicians", "🎵 Variety Songs", "🔊 Full Sound Setup", "💡 Stage Lighting", "🎼 Live Singers"]],
    ["id" => 5012, "title" => "Premium Live Band", "subtitle" => "Premium Live Band", "image" => "./images/band2.jpg", "price" => "PKR 120,000", "rating" => "4.9", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "5 Hours", "location" => "On-Site", "type" => "Premium Band", "description" => "Premium live band with full ensemble.", "features" => ["🎸 5 Hours Performance", "🎤 8 Musicians", "🎵 Extensive Repertoire", "🔊 Premium Sound", "💡 Concert Lighting", "🎼 Lead Singers"]],
    ["id" => 5013, "title" => "Jazz Band", "subtitle" => "Elegant Jazz Band", "image" => "./images/band3.jpg", "price" => "PKR 90,000", "rating" => "4.8", "guests" => "50-1000 Guests", "capacity" => "Any Size", "timing" => "4 Hours", "location" => "On-Site", "type" => "Jazz Band", "description" => "Elegant jazz band for sophisticated weddings.", "features" => ["🎷 Jazz Ensemble", "🎹 Piano & Sax", "🎵 Classic Jazz", "🔊 Premium Sound", "💡 Ambient Lighting", "🎼 Jazz Singers"]],
    ["id" => 5014, "title" => "Rock Band", "subtitle" => "High Energy Rock Band", "image" => "./images/band4.jpg", "price" => "PKR 100,000", "rating" => "4.7", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "4 Hours", "location" => "On-Site", "type" => "Rock Band", "description" => "High energy rock band for a rocking wedding.", "features" => ["🎸 Rock Band", "🎤 6 Musicians", "🎵 Rock Anthems", "🔊 High Power Sound", "💡 Rock Lighting", "🎼 Rock Singers"]],
    ["id" => 5015, "title" => "Sufi Night", "subtitle" => "Sufi Music Night", "image" => "./images/band5.jpg", "price" => "PKR 85,000", "rating" => "4.9", "guests" => "50-1500 Guests", "capacity" => "Any Size", "timing" => "4 Hours", "location" => "On-Site", "type" => "Sufi Night", "description" => "Sufi music night with soulful performance.", "features" => ["🎤 Sufi Singers", "🎵 Qawwali & Sufi", "🔊 Traditional Sound", "💡 Ambient Lighting", "🥁 Live Tabla", "🎼 Harmonium"]],
    ["id" => 5016, "title" => "Orchestra Night", "subtitle" => "Grand Orchestra Night", "image" => "./images/band6.jpg", "price" => "PKR 200,000", "rating" => "5.0", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "4 Hours", "location" => "On-Site", "type" => "Orchestra", "description" => "Grand orchestra night with 20+ musicians.", "features" => ["🎻 Full Orchestra", "🎺 20+ Musicians", "🎵 Classical + Modern", "🔊 Concert Sound", "💡 Grand Lighting", "🎼 Conductor"]]
];

// ---------- 502 - DJ Night ----------
$sub_products[502] = [
    ["id" => 5021, "title" => "DJ Night", "subtitle" => "Professional DJ", "image" => "./images/dj1.jpg", "price" => "PKR 50,000", "rating" => "4.7", "guests" => "50-2000 Guests", "capacity" => "Any Size", "timing" => "6 Hours", "location" => "On-Site", "type" => "DJ Service", "description" => "Professional DJ for your wedding.", "features" => ["🎧 6 Hours Set", "🔊 Premium Sound", "💡 Lighting Setup", "🎵 Request Management", "🎤 MC Service", "🎉 Party Mode"]],
    ["id" => 5022, "title" => "Premium DJ", "subtitle" => "Premium DJ Experience", "image" => "./images/dj2.jpg", "price" => "PKR 80,000", "rating" => "4.8", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "8 Hours", "location" => "On-Site", "type" => "Premium DJ", "description" => "Premium DJ experience with laser show.", "features" => ["🎧 8 Hours Set", "🔊 Concert Sound", "💡 Laser Show", "🎵 Live Mixing", "🎤 Professional MC", "🎉 Party Effects"]],
    ["id" => 5023, "title" => "DJ + Dhol", "subtitle" => "DJ with Dhol Combo", "image" => "./images/dj3.jpg", "price" => "PKR 65,000", "rating" => "4.8", "guests" => "50-2000 Guests", "capacity" => "Any Size", "timing" => "6 Hours", "location" => "On-Site", "type" => "DJ + Dhol", "description" => "DJ with dhol combo for full entertainment.", "features" => ["🎧 6 Hours DJ", "🥁 Dhol Performance", "🔊 Premium Sound", "💡 Lighting Setup", "🎵 Bollywood + Punjabi", "🎉 Party Mode"]],
    ["id" => 5024, "title" => "Bollywood DJ", "subtitle" => "Bollywood DJ Night", "image" => "./images/dj4.jpg", "price" => "PKR 70,000", "rating" => "4.8", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "6 Hours", "location" => "On-Site", "type" => "Bollywood DJ", "description" => "Bollywood DJ night with all hits.", "features" => ["🎧 6 Hours Set", "🎵 Bollywood Hits", "🔊 Premium Sound", "💡 Lighting Setup", "🎤 MC Service", "🎉 Dance Floor"]],
    ["id" => 5025, "title" => "EDM DJ", "subtitle" => "EDM DJ Night", "image" => "./images/dj5.jpg", "price" => "PKR 90,000", "rating" => "4.9", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "8 Hours", "location" => "On-Site", "type" => "EDM DJ", "description" => "EDM DJ night with festival vibes.", "features" => ["🎧 8 Hours EDM", "🔊 Festival Sound", "💡 LED Wall", "🎵 Live Remixing", "🎤 MC Service", "🎉 CO2 Effects"]],
    ["id" => 5026, "title" => "Celebrity DJ", "subtitle" => "Celebrity DJ Night", "image" => "./images/dj6.jpg", "price" => "PKR 150,000", "rating" => "5.0", "guests" => "200-2000 Guests", "capacity" => "Any Size", "timing" => "8 Hours", "location" => "On-Site", "type" => "Celebrity DJ", "description" => "Celebrity DJ night for a star-studded event.", "features" => ["🎧 Celebrity DJ", "🔊 Concert Sound", "💡 Full Production", "🎵 Live Remixing", "🎤 Celebrity MC", "🎉 Full Effects"]]
];

// ---------- 503 - Qawwali Night ----------
$sub_products[503] = [
    ["id" => 5031, "title" => "Qawwali Night", "subtitle" => "Traditional Qawwali", "image" => "./images/qawwali1.jpg", "price" => "PKR 60,000", "rating" => "4.9", "guests" => "50-2000 Guests", "capacity" => "Any Size", "timing" => "3 Hours", "location" => "On-Site", "type" => "Qawwali", "description" => "Traditional Qawwali performance.", "features" => ["🎤 2 Hours Show", "👥 Professional Artists", "🥁 Traditional Setup", "🎵 Live Performance", "🔊 Premium Sound", "🎼 Harmonium & Tabla"]],
    ["id" => 5032, "title" => "Premium Qawwali", "subtitle" => "Premium Qawwali Night", "image" => "./images/qawwali2.jpg", "price" => "PKR 100,000", "rating" => "5.0", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "4 Hours", "location" => "On-Site", "type" => "Premium Qawwali", "description" => "Premium Qawwali night with famous artists.", "features" => ["🎤 3 Hours Show", "👥 Famous Qawwals", "🥁 Traditional Setup", "🎵 Live Performance", "🔊 Concert Sound", "🎼 Full Ensemble"]],
    ["id" => 5033, "title" => "Qawwali + Sufi", "subtitle" => "Qawwali + Sufi Night", "image" => "./images/qawwali3.jpg", "price" => "PKR 80,000", "rating" => "4.9", "guests" => "50-1500 Guests", "capacity" => "Any Size", "timing" => "4 Hours", "location" => "On-Site", "type" => "Qawwali + Sufi", "description" => "Qawwali and Sufi night combination.", "features" => ["🎤 Qawwali + Sufi", "👥 Professional Artists", "🥁 Traditional Setup", "🎵 Live Performance", "🔊 Premium Sound", "🎼 Full Band"]],
    ["id" => 5034, "title" => "Mehndi Qawwali", "subtitle" => "Mehndi Qawwali Night", "image" => "./images/qawwali14.jpg", "price" => "PKR 70,000", "rating" => "4.8", "guests" => "100-1000 Guests", "capacity" => "Any Size", "timing" => "3 Hours", "location" => "On-Site", "type" => "Mehndi Qawwali", "description" => "Mehndi Qawwali night with traditional vibes.", "features" => ["🎤 3 Hours Show", "👥 Qawwali Group", "🥁 Traditional Setup", "🎵 Mehndi Songs", "🔊 Sound Setup", "🎼 Full Band"]],
    ["id" => 5035, "title" => "Grand Qawwali", "subtitle" => "Grand Qawwali Night", "image" => "./images/qawwali15.jpg", "price" => "PKR 150,000", "rating" => "5.0", "guests" => "200-3000 Guests", "capacity" => "Any Size", "timing" => "5 Hours", "location" => "On-Site", "type" => "Grand Qawwali", "description" => "Grand Qawwali night with celebrity Qawwals.", "features" => ["🎤 5 Hours Show", "👥 Celebrity Qawwals", "🥁 Traditional Setup", "🎵 Live Performance", "🔊 Concert Sound", "🎼 Full Ensemble"]],
    ["id" => 5036, "title" => "Qawwali Night Special", "subtitle" => "Special Qawwali Night", "image" => "./images/qawwali16.jpg", "price" => "PKR 200,000", "rating" => "5.0", "guests" => "200-3000 Guests", "capacity" => "Any Size", "timing" => "6 Hours", "location" => "On-Site", "type" => "Special Qawwali", "description" => "Special Qawwali night with legendary artists.", "features" => ["🎤 6 Hours Show", "👥 Legendary Qawwals", "🥁 Traditional Setup", "🎵 Live Performance", "🔊 Premium Sound", "🎼 Full Orchestra"]]
];

// ---------- 504 - Dhol Performance ----------
$sub_products[504] = [
    ["id" => 5041, "title" => "Dhol Performance", "subtitle" => "Traditional Dhol", "image" => "./images/dhol1.jpg", "price" => "PKR 20,000", "rating" => "4.6", "guests" => "50-2000 Guests", "capacity" => "Any Size", "timing" => "1 Hour", "location" => "On-Site", "type" => "Dhol Service", "description" => "Traditional Dhol performance.", "features" => ["🥁 Professional Dhol", "🎵 Live Performance", "🎉 Bridal Entry", "💃 Full Energy", "🔊 Amplified Sound", "🎼 Traditional Beats"]],
    ["id" => 5042, "title" => "Dhol Team", "subtitle" => "Professional Dhol Team", "image" => "./images/dhol2.jpg", "price" => "PKR 35,000", "rating" => "4.8", "guests" => "50-2000 Guests", "capacity" => "Any Size", "timing" => "2 Hours", "location" => "On-Site", "type" => "Dhol Team", "description" => "Professional dhol team for full energy.", "features" => ["🥁 4 Dhol Players", "🎵 Live Performance", "🎉 Bridal Entry", "💃 Dance Performance", "🔊 Amplified Sound", "🎼 Traditional Beats"]],
    ["id" => 5043, "title" => "Dhol + Nagara", "subtitle" => "Dhol + Nagara Performance", "image" => "./images/dhol3.jpg", "price" => "PKR 30,000", "rating" => "4.7", "guests" => "50-2000 Guests", "capacity" => "Any Size", "timing" => "1.5 Hours", "location" => "On-Site", "type" => "Dhol + Nagara", "description" => "Dhol and Nagara traditional combo.", "features" => ["🥁 Dhol + Nagara", "🎵 Live Performance", "🎉 Bridal Entry", "💃 Dance Performance", "🔊 Sound Setup", "🎼 Traditional Beats"]],
    ["id" => 5044, "title" => "Dhol Night", "subtitle" => "Dhol Night Performance", "image" => "./images/dhol4.jpg", "price" => "PKR 50,000", "rating" => "4.8", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "3 Hours", "location" => "On-Site", "type" => "Dhol Night", "description" => "Dhol night with continuous performance.", "features" => ["🥁 6 Dhol Players", "🎵 3 Hours Show", "🎉 Mehndi Night", "💃 Dance Floor", "🔊 Premium Sound", "🎼 Live Beats"]],
    ["id" => 5045, "title" => "Dhol + Bhangra", "subtitle" => "Dhol + Bhangra Performance", "image" => "./images/dhol5.jpg", "price" => "PKR 60,000", "rating" => "4.9", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "3 Hours", "location" => "On-Site", "type" => "Dhol + Bhangra", "description" => "Dhol with Bhangra dancers performance.", "features" => ["🥁 4 Dhol Players", "💃 6 Bhangra Dancers", "🎵 3 Hours Show", "🎉 Full Energy", "🔊 Premium Sound", "🎼 Live Beats"]],
    ["id" => 5046, "title" => "Dhol Grand", "subtitle" => "Grand Dhol Performance", "image" => "./images/dhol6.jpg", "price" => "PKR 100,000", "rating" => "5.0", "guests" => "200-3000 Guests", "capacity" => "Any Size", "timing" => "5 Hours", "location" => "On-Site", "type" => "Grand Dhol", "description" => "Grand dhol performance with full team.", "features" => ["🥁 10 Dhol Players", "💃 10 Dancers", "🎵 5 Hours Show", "🎉 Multi-Event", "🔊 Concert Sound", "🎼 Live Beats"]]
];

// ---------- 505 - Fireworks Show ----------
$sub_products[505] = [
    ["id" => 5051, "title" => "Fireworks Show", "subtitle" => "Spectacular Fireworks", "image" => "./images/fireworks1.jpg", "price" => "PKR 150,000", "rating" => "5.0", "guests" => "50-5000 Guests", "capacity" => "Any Size", "timing" => "10 Mins", "location" => "On-Site", "type" => "Fireworks", "description" => "Spectacular fireworks display.", "features" => ["🎆 10 Minutes Show", "🎇 Professional Setup", "✅ Safety Certified", "🎨 Custom Design", "🔊 Music Sync", "🎉 Grand Finale"]],
    ["id" => 5052, "title" => "Grand Fireworks", "subtitle" => "Grand Fireworks Show", "image" => "./images/fireworks2.jpg", "price" => "PKR 250,000", "rating" => "5.0", "guests" => "100-5000 Guests", "capacity" => "Any Size", "timing" => "15 Mins", "location" => "On-Site", "type" => "Grand Fireworks", "description" => "Grand fireworks show with music.", "features" => ["🎆 15 Minutes Show", "🎇 Premium Setup", "✅ Safety Certified", "🎨 Custom Design", "🔊 Music Sync", "🎉 Multi-Color"]],
    ["id" => 5053, "title" => "Wedding Fireworks", "subtitle" => "Wedding Day Fireworks", "image" => "./images/fireworks3.jpg", "price" => "PKR 200,000", "rating" => "5.0", "guests" => "100-5000 Guests", "capacity" => "Any Size", "timing" => "12 Mins", "location" => "On-Site", "type" => "Wedding Fireworks", "description" => "Wedding day fireworks with synchronized music.", "features" => ["🎆 12 Minutes Show", "🎇 Wedding Theme", "✅ Safety Certified", "🎨 Custom Design", "🔊 Music Sync", "💑 Couple Names"]],
    ["id" => 5054, "title" => "Cold Fireworks", "subtitle" => "Cold Fireworks Show", "image" => "./images/fireworks4.jpg", "price" => "PKR 100,000", "rating" => "4.9", "guests" => "50-2000 Guests", "capacity" => "Any Size", "timing" => "10 Mins", "location" => "On-Site", "type" => "Cold Fireworks", "description" => "Indoor cold fireworks for stage entry.", "features" => ["❄️ Cold Sparks", "🎆 10 Minutes Show", "✅ Indoor Safe", "🎨 Custom Design", "🔊 Music Sync", "🎉 Stage Entry"]],
    ["id" => 5055, "title" => "Sky Fireworks", "subtitle" => "Sky High Fireworks", "image" => "./images/fireworks5.jpg", "price" => "PKR 350,000", "rating" => "5.0", "guests" => "200-5000 Guests", "capacity" => "Any Size", "timing" => "20 Mins", "location" => "On-Site", "type" => "Sky Fireworks", "description" => "Sky high fireworks with grand finale.", "features" => ["🎆 20 Minutes Show", "🎇 Sky High Shells", "✅ Safety Certified", "🎨 Custom Design", "🔊 Music Sync", "🎉 Grand Finale"]],
    ["id" => 5056, "title" => "Mega Fireworks", "subtitle" => "Mega Fireworks Show", "image" => "./images/fireworks6.jpg", "price" => "PKR 500,000", "rating" => "5.0", "guests" => "500-10000 Guests", "capacity" => "Any Size", "timing" => "30 Mins", "location" => "On-Site", "type" => "Mega Fireworks", "description" => "Mega fireworks show for the grandest event.", "features" => ["🎆 30 Minutes Show", "🎇 Multi-Position", "✅ Safety Certified", "🎨 Custom Design", "🔊 Music Sync", "🎉 Pyro Musical"]]
];

// ---------- 506 - Cold Pyro Effects ----------
$sub_products[506] = [
    ["id" => 5061, "title" => "Cold Pyro Effects", "subtitle" => "Premium Cold Pyro", "image" => "./images/pyro1.jpg", "price" => "PKR 45,000", "rating" => "4.8", "guests" => "50-2000 Guests", "capacity" => "Any Size", "timing" => "2 Hours", "location" => "On-Site", "type" => "Cold Pyro", "description" => "Premium cold pyro effects for stage.", "features" => ["❄️ Cold Sparks", "🎇 Professional Setup", "✅ Safety Certified", "🎨 Custom Effects", "🔊 Music Sync", "✨ Stage Effect"]],
    ["id" => 5062, "title" => "Cold Pyro Fountain", "subtitle" => "Cold Pyro Fountain", "image" => "./images/pyro2.jpg", "price" => "PKR 65,000", "rating" => "4.9", "guests" => "50-2000 Guests", "capacity" => "Any Size", "timing" => "3 Hours", "location" => "On-Site", "type" => "Pyro Fountain", "description" => "Cold pyro fountain for bridal entry.", "features" => ["❄️ Pyro Fountain", "🎇 Multi-Color Sparks", "✅ Safety Certified", "🎨 Custom Design", "🔊 Music Sync", "✨ Bridal Entry"]],
    ["id" => 5063, "title" => "Cold Pyro Stage", "subtitle" => "Cold Pyro Stage Show", "image" => "./images/pyro3.jpg", "price" => "PKR 80,000", "rating" => "4.9", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "3 Hours", "location" => "On-Site", "type" => "Pyro Stage", "description" => "Cold pyro stage show with effects.", "features" => ["❄️ Stage Pyro", "🎇 8 Effects", "✅ Safety Certified", "🎨 Custom Design", "🔊 Music Sync", "✨ Full Stage"]],
    ["id" => 5064, "title" => "Cold Pyro Grand", "subtitle" => "Grand Cold Pyro Show", "image" => "./images/pyro4.jpg", "price" => "PKR 120,000", "rating" => "5.0", "guests" => "100-2000 Guests", "capacity" => "Any Size", "timing" => "4 Hours", "location" => "On-Site", "type" => "Grand Pyro", "description" => "Grand cold pyro show with full effects.", "features" => ["❄️ Grand Pyro", "🎇 15 Effects", "✅ Safety Certified", "🎨 Custom Design", "🔊 Music Sync", "✨ Full Production"]],
    ["id" => 5065, "title" => "Cold Pyro Wedding", "subtitle" => "Wedding Cold Pyro", "image" => "./images/pyro5.jpg", "price" => "PKR 90,000", "rating" => "4.9", "guests" => "50-2000 Guests", "capacity" => "Any Size", "timing" => "3 Hours", "location" => "On-Site", "type" => "Wedding Pyro", "description" => "Wedding cold pyro effects for all events.", "features" => ["❄️ Wedding Pyro", "🎇 10 Effects", "✅ Safety Certified", "🎨 Custom Design", "🔊 Music Sync", "✨ Multi-Event"]],
    ["id" => 5066, "title" => "Cold Pyro Mega", "subtitle" => "Mega Cold Pyro Show", "image" => "./images/pyro6.jpg", "price" => "PKR 180,000", "rating" => "5.0", "guests" => "200-5000 Guests", "capacity" => "Any Size", "timing" => "5 Hours", "location" => "On-Site", "type" => "Mega Pyro", "description" => "Mega cold pyro show for grand events.", "features" => ["❄️ Mega Pyro", "🎇 20 Effects", "✅ Safety Certified", "🎨 Custom Design", "🔊 Music Sync", "✨ Full Production"]]
];

// ---------- 601 - Luxury Hall Booking ----------
$sub_products[601] = [
    ["id" => 6011, "title" => "Luxury Hall", "subtitle" => "Premium Luxury Hall", "image" => "./images/luxhall1.jpg", "price" => "PKR 200,000", "rating" => "4.7", "guests" => "100-2000 Guests", "capacity" => "500-1000 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Indoor Hall", "description" => "Premium luxury hall booking.", "features" => ["🏛️ Premium Hall", "🛋️ VIP Lounge", "🎭 Backstage Area", "💡 Premium Lighting", "❄️ AC Hall", "🅿️ Valet Parking"]],
    ["id" => 6012, "title" => "Grand Hall", "subtitle" => "Grand Luxury Hall", "image" => "./images/luxhall2.jpg", "price" => "PKR 300,000", "rating" => "4.8", "guests" => "200-2000 Guests", "capacity" => "800-1500 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Grand Hall", "description" => "Grand luxury hall with premium features.", "features" => ["🏛️ Grand Hall", "🛋️ VIP Lounge", "🎭 Backstage Area", "💡 Chandelier Lighting", "❄️ AC Hall", "🅿️ Valet Parking"]],
    ["id" => 6013, "title" => "Executive Hall", "subtitle" => "Executive Luxury Hall", "image" => "./images/luxhall3.jpg", "price" => "PKR 400,000", "rating" => "4.9", "guests" => "200-1500 Guests", "capacity" => "500-1000 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Executive Hall", "description" => "Executive luxury hall with premium amenities.", "features" => ["🏛️ Executive Hall", "🛋️ VIP Lounge", "🎭 Backstage Area", "💡 Premium Lighting", "❄️ AC Hall", "🅿️ Valet Parking"]],
    ["id" => 6014, "title" => "Elite Hall", "subtitle" => "Elite Luxury Hall", "image" => "./images/luxhall4.jpg", "price" => "PKR 500,000", "rating" => "5.0", "guests" => "300-2000 Guests", "capacity" => "1000-2000 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Elite Hall", "description" => "Elite luxury hall with exclusive services.", "features" => ["🏛️ Elite Hall", "🛋️ Elite Lounge", "🎭 Backstage Area", "💡 Luxury Lighting", "❄️ AC Hall", "🅿️ Valet Parking"]],
    ["id" => 6015, "title" => "Diamond Hall", "subtitle" => "Diamond Luxury Hall", "image" => "./images/luxhall5.jpg", "price" => "PKR 700,000", "rating" => "5.0", "guests" => "300-2000 Guests", "capacity" => "1000-2000 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Diamond Hall", "description" => "Diamond luxury hall with ultimate amenities.", "features" => ["🏛️ Diamond Hall", "🛋️ Diamond Lounge", "🎭 Backstage Area", "💡 Crystal Lighting", "❄️ AC Hall", "🅿️ Valet Parking"]],
    ["id" => 6016, "title" => "Royal Hall", "subtitle" => "Royal Luxury Hall", "image" => "./images/luxhall6.jpg", "price" => "PKR 1,000,000", "rating" => "5.0", "guests" => "500-3000 Guests", "capacity" => "1500-3000 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Royal Hall", "description" => "Royal luxury hall for grand weddings.", "features" => ["🏛️ Royal Hall", "🛋️ Royal Lounge", "🎭 Backstage Area", "💡 Royal Lighting", "❄️ AC Hall", "🅿️ Valet Parking"]]
];

// ---------- 602 - Royal Ballroom ----------
$sub_products[602] = [
    ["id" => 6021, "title" => "Royal Ballroom", "subtitle" => "Grand Royal Ballroom", "image" => "./images/ballroom1.jpg", "price" => "PKR 400,000", "rating" => "4.9", "guests" => "100-2000 Guests", "capacity" => "500-1000 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Ballroom", "description" => "Royal ballroom for grand weddings.", "features" => ["🏛️ Grand Ballroom", "💎 Chandelier Lighting", "👑 Royal Décor", "🛋️ VIP Lounge", "❄️ AC Hall", "🅿️ Valet Parking"]],
    ["id" => 6022, "title" => "Crystal Ballroom", "subtitle" => "Crystal Grand Ballroom", "image" => "./images/ballroom2.jpg", "price" => "PKR 500,000", "rating" => "5.0", "guests" => "200-2000 Guests", "capacity" => "800-1500 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Crystal Ballroom", "description" => "Crystal ballroom with stunning crystal decor.", "features" => ["🏛️ Crystal Ballroom", "💎 Crystal Chandeliers", "✨ Mirror Décor", "🛋️ VIP Lounge", "❄️ AC Hall", "🅿️ Valet Parking"]],
    ["id" => 6023, "title" => "Diamond Ballroom", "subtitle" => "Diamond Grand Ballroom", "image" => "./images/ballroom3.jpg", "price" => "PKR 700,000", "rating" => "5.0", "guests" => "300-2000 Guests", "capacity" => "1000-2000 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Diamond Ballroom", "description" => "Diamond ballroom with ultimate luxury.", "features" => ["🏛️ Diamond Ballroom", "💎 Diamond Chandeliers", "✨ Premium Décor", "🛋️ Diamond Lounge", "❄️ AC Hall", "🅿️ Valet Parking"]],
    ["id" => 6024, "title" => "Imperial Ballroom", "subtitle" => "Imperial Grand Ballroom", "image" => "./images/ballroom4.jpg", "price" => "PKR 900,000", "rating" => "5.0", "guests" => "400-2500 Guests", "capacity" => "1200-2500 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Imperial Ballroom", "description" => "Imperial ballroom for grand celebrations.", "features" => ["🏛️ Imperial Ballroom", "💎 Imperial Chandeliers", "👑 Imperial Décor", "🛋️ Imperial Lounge", "❄️ AC Hall", "🅿️ Valet Parking"]],
    ["id" => 6025, "title" => "Platinum Ballroom", "subtitle" => "Platinum Grand Ballroom", "image" => "./imagesballroom5.jpg", "price" => "PKR 1,200,000", "rating" => "5.0", "guests" => "500-3000 Guests", "capacity" => "1500-3000 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Platinum Ballroom", "description" => "Platinum ballroom for the grandest celebrations.", "features" => ["🏛️ Platinum Ballroom", "💎 Platinum Chandeliers", "✨ Platinum Décor", "🛋️ Platinum Lounge", "❄️ AC Hall", "🅿️ Valet Parking"]],
    ["id" => 6026, "title" => "Maharaja Ballroom", "subtitle" => "Maharaja Grand Ballroom", "image" => "./images/ballroom6.jpg", "price" => "PKR 1,500,000", "rating" => "5.0", "guests" => "500-3000 Guests", "capacity" => "1500-3000 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Maharaja Ballroom", "description" => "Maharaja ballroom for royal weddings.", "features" => ["🏛️ Maharaja Ballroom", "💎 Maharaja Chandeliers", "👑 Royal Décor", "🛋️ Royal Lounge", "❄️ AC Hall", "🅿️ Valet Parking"]]
];

// ---------- 603 - Outdoor Garden ----------
$sub_products[603] = [
    ["id" => 6031, "title" => "Outdoor Garden", "subtitle" => "Beautiful Outdoor Garden", "image" => "./images/outdor1.jpg", "price" => "PKR 150,000", "rating" => "4.6", "guests" => "50-1000 Guests", "capacity" => "200-500 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Garden Venue", "description" => "Beautiful outdoor garden for weddings.", "features" => ["🌿 Garden Setup", "☀️ Natural Lighting", "🪑 Premium Seating", "🎭 Stage Area", "🌸 Floral Décor", "🅿️ Parking"]],
    ["id" => 6032, "title" => "Rose Garden", "subtitle" => "Rose Garden Wedding", "image" => "./images/outdor2.jpg", "price" => "PKR 200,000", "rating" => "4.7", "guests" => "100-1000 Guests", "capacity" => "300-800 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Rose Garden", "description" => "Rose garden wedding venue.", "features" => ["🌹 Rose Garden", "🌸 Floral Décor", "🪑 Premium Seating", "🎭 Stage Area", "☀️ Natural Light", "🅿️ Parking"]],
    ["id" => 6033, "title" => "Lake Side Garden", "subtitle" => "Lake Side Garden Wedding", "image" => "./images/outdor3.jpg", "price" => "PKR 250,000", "rating" => "4.8", "guests" => "100-1000 Guests", "capacity" => "300-800 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Lake Garden", "description" => "Lake side garden with beautiful views.", "features" => ["🌊 Lake View", "🌿 Garden Setup", "🪑 Premium Seating", "🎭 Stage Area", "☀️ Natural Light", "🅿️ Parking"]],
    ["id" => 6034, "title" => "Palm Garden", "subtitle" => "Palm Garden Wedding", "image" => "./images/outdor4.jpg", "price" => "PKR 300,000", "rating" => "4.8", "guests" => "100-1500 Guests", "capacity" => "500-1000 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Palm Garden", "description" => "Palm garden wedding venue with tropical vibes.", "features" => ["🌴 Palm Trees", "🌿 Garden Setup", "🪑 Premium Seating", "🎭 Stage Area", "☀️ Natural Light", "🅿️ Parking"]],
    ["id" => 6035, "title" => "Fountain Garden", "subtitle" => "Fountain Garden Wedding", "image" => "./images/outdor5.jpg", "price" => "PKR 400,000", "rating" => "4.9", "guests" => "150-1500 Guests", "capacity" => "500-1000 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Fountain Garden", "description" => "Fountain garden with dancing fountains.", "features" => ["⛲ Fountain Show", "🌿 Garden Setup", "🪑 Premium Seating", "🎭 Stage Area", "💡 Light Show", "🅿️ Parking"]],
    ["id" => 6036, "title" => "Grand Garden", "subtitle" => "Grand Garden Wedding", "image" => "./images/outdor6.jpg", "price" => "PKR 600,000", "rating" => "5.0", "guests" => "200-2000 Guests", "capacity" => "800-1500 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Grand Garden", "description" => "Grand garden for large outdoor weddings.", "features" => ["🌳 Grand Garden", "🌸 Floral Décor", "🪑 Grand Seating", "🎭 Grand Stage", "💡 Light Show", "🅿️ Valet Parking"]]
];

// ---------- 604 - Palace Theme Venue ----------
$sub_products[604] = [
    ["id" => 6041, "title" => "Palace Theme", "subtitle" => "Royal Palace Theme Venue", "image" => "./images/palace1.jpg", "price" => "PKR 350,000", "rating" => "4.8", "guests" => "100-2000 Guests", "capacity" => "500-1000 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Palace Venue", "description" => "Palace themed wedding venue.", "features" => ["🏰 Palace Theme", "👑 Royal Décor", "🚪 Grand Entrance", "🪑 Royal Seating", "💡 Palace Lighting", "🅿️ Valet Parking"]],
    ["id" => 6042, "title" => "Mughal Palace", "subtitle" => "Mughal Palace Venue", "image" => "./images/palace2.jpg", "price" => "PKR 400,000", "rating" => "4.9", "guests" => "100-2000 Guests", "capacity" => "500-1000 Pax", "timing" => "Full Day", "location" => "Lahore, Pakistan", "type" => "Mughal Palace", "description" => "Mughal palace themed wedding venue.", "features" => ["🏰 Mughal Theme", "👑 Mughal Décor", "🚪 Grand Entrance", "🪑 Royal Seating", "💡 Mughal Lighting", "🅿️ Valet Parking"]],
    ["id" => 6043, "title" => "Rajputana Palace", "subtitle" => "Rajputana Palace Venue", "image" => "./images/palace3.jpg", "price" => "PKR 450,000", "rating" => "4.9", "guests" => "150-2000 Guests", "capacity" => "800-1500 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Rajputana Palace", "description" => "Rajputana palace themed venue.", "features" => ["🏰 Rajputana Theme", "👑 Royal Décor", "🚪 Grand Entrance", "🪑 Royal Seating", "💡 Palace Lighting", "🅿️ Valet Parking"]],
    ["id" => 6044, "title" => "Ottoman Palace", "subtitle" => "Ottoman Palace Venue", "image" => "./images/palace4.jpg", "price" => "PKR 500,000", "rating" => "5.0", "guests" => "200-2000 Guests", "capacity" => "800-1500 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Ottoman Palace", "description" => "Ottoman palace themed venue.", "features" => ["🏰 Ottoman Theme", "👑 Royal Décor", "🚪 Grand Entrance", "🪑 Royal Seating", "💡 Palace Lighting", "🅿️ Valet Parking"]],
    ["id" => 6045, "title" => "Persian Palace", "subtitle" => "Persian Palace Venue", "image" => "./images/palace5.jpg", "price" => "PKR 600,000", "rating" => "5.0", "guests" => "200-2000 Guests", "capacity" => "800-1500 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Persian Palace", "description" => "Persian palace themed venue.", "features" => ["🏰 Persian Theme", "👑 Royal Décor", "🚪 Grand Entrance", "🪑 Royal Seating", "💡 Palace Lighting", "🅿️ Valet Parking"]],
    ["id" => 6046, "title" => "Grand Palace", "subtitle" => "Grand Palace Venue", "image" => "./images/palace6.jpg", "price" => "PKR 800,000", "rating" => "5.0", "guests" => "300-3000 Guests", "capacity" => "1000-2000 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Grand Palace", "description" => "Grand palace for the most luxurious weddings.", "features" => ["🏰 Grand Palace", "👑 Royal Décor", "🚪 Grand Entrance", "🪑 Royal Seating", "💡 Grand Lighting", "🅿️ Valet Parking"]]
];

// ---------- 605 - VIP Lounge ----------
$sub_products[605] = [
    ["id" => 6051, "title" => "VIP Lounge", "subtitle" => "Exclusive VIP Lounge", "image" => "./images/lounge1.jpg", "price" => "PKR 100,000", "rating" => "4.7", "guests" => "20-200 Guests", "capacity" => "50-100 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "VIP Lounge", "description" => "Exclusive VIP lounge for special guests.", "features" => ["🛋️ VIP Area", "🪑 Premium Seating", "👨‍🍳 Exclusive Service", "🔒 Privacy", "❄️ AC Lounge", "🥤 Premium Drinks"]],
    ["id" => 6052, "title" => "Royal Lounge", "subtitle" => "Royal VIP Lounge", "image" => "./images/lounge2.jpg", "price" => "PKR 150,000", "rating" => "4.8", "guests" => "30-200 Guests", "capacity" => "50-100 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Royal Lounge", "description" => "Royal VIP lounge with luxury service.", "features" => ["🛋️ Royal Lounge", "🪑 Royal Seating", "👨‍🍳 Butler Service", "🔒 Privacy", "❄️ AC Lounge", "🥤 Premium Bar"]],
    ["id" => 6053, "title" => "Diamond Lounge", "subtitle" => "Diamond VIP Lounge", "image" => "./images/lounge3.jpg", "price" => "PKR 200,000", "rating" => "4.9", "guests" => "40-300 Guests", "capacity" => "80-150 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Diamond Lounge", "description" => "Diamond VIP lounge with exclusive service.", "features" => ["🛋️ Diamond Lounge", "🪑 Diamond Seating", "👨‍🍳 Personal Chef", "🔒 Privacy", "❄️ AC Lounge", "🥤 Premium Bar"]],
    ["id" => 6054, "title" => "Elite Lounge", "subtitle" => "Elite VIP Lounge", "image" => "./images/lounge4.jpg", "price" => "PKR 300,000", "rating" => "5.0", "guests" => "50-300 Guests", "capacity" => "100-200 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Elite Lounge", "description" => "Elite VIP lounge with premium amenities.", "features" => ["🛋️ Elite Lounge", "🪑 Elite Seating", "👨‍🍳 Elite Service", "🔒 Privacy", "❄️ AC Lounge", "🥤 Premium Bar"]],
    ["id" => 6055, "title" => "Celebrity Lounge", "subtitle" => "Celebrity VIP Lounge", "image" => "./images/lounge5.jpg", "price" => "PKR 400,000", "rating" => "5.0", "guests" => "50-300 Guests", "capacity" => "100-200 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Celebrity Lounge", "description" => "Celebrity VIP lounge for high-profile guests.", "features" => ["🛋️ Celebrity Lounge", "🪑 Premium Seating", "👨‍🍳 Celebrity Chef", "🔒 Full Privacy", "❄️ AC Lounge", "🥤 Premium Bar"]],
    ["id" => 6056, "title" => "Presidential Lounge", "subtitle" => "Presidential VIP Lounge", "image" => "./images/lounge6.jpg", "price" => "PKR 500,000", "rating" => "5.0", "guests" => "50-300 Guests", "capacity" => "100-200 Pax", "timing" => "Full Day", "location" => "Karachi, Pakistan", "type" => "Presidential Lounge", "description" => "Presidential VIP lounge for VVIP guests.", "features" => ["🛋️ Presidential Lounge", "🪑 Presidential Seating", "👨‍🍳 Presidential Chef", "🔒 Full Privacy", "❄️ AC Lounge", "🥤 Premium Bar"]]
];

// ---------- 606 - Complete Venue Management ----------
$sub_products[606] = [
    ["id" => 6061, "title" => "Venue Management", "subtitle" => "Complete Venue Management", "image" => "./images/compvenue1.jpg", "price" => "PKR 500,000", "rating" => "5.0", "guests" => "50-5000 Guests", "capacity" => "Any Size", "timing" => "Full Day", "location" => "Worldwide", "type" => "Venue Management", "description" => "Complete venue management package.", "features" => ["🏛️ Venue Selection", "🎭 Full Décor", "🎪 Vendor Coordination", "📋 Day Management", "👥 Staff Management", "🚗 Transport"]],
    ["id" => 6062, "title" => "Premium Venue", "subtitle" => "Premium Venue Management", "image" => "./images/compvenue2.jpg", "price" => "PKR 700,000", "rating" => "5.0", "guests" => "100-5000 Guests", "capacity" => "Any Size", "timing" => "Full Day", "location" => "Worldwide", "type" => "Premium Management", "description" => "Premium venue management with full service.", "features" => ["🏛️ Premium Venue", "🎭 Premium Décor", "🎪 Full Coordination", "📋 Day Management", "👥 Premium Staff", "🚗 Luxury Transport"]],
    ["id" => 6063, "title" => "Royal Venue", "subtitle" => "Royal Venue Management", "image" => "./images/compvenue3.jpg", "price" => "PKR 1,000,000", "rating" => "5.0", "guests" => "150-5000 Guests", "capacity" => "Any Size", "timing" => "Full Day", "location" => "Worldwide", "type" => "Royal Management", "description" => "Royal venue management with royal treatment.", "features" => ["🏰 Royal Venue", "👑 Royal Décor", "🎪 Royal Coordination", "📋 Royal Management", "👥 Royal Staff", "🚗 Royal Transport"]],
    ["id" => 6064, "title" => "Elite Venue", "subtitle" => "Elite Venue Management", "image" => "./images/compvenue4.jpg", "price" => "PKR 1,500,000", "rating" => "5.0", "guests" => "200-5000 Guests", "capacity" => "Any Size", "timing" => "Full Day", "location" => "Worldwide", "type" => "Elite Management", "description" => "Elite venue management with elite services.", "features" => ["🏛️ Elite Venue", "💎 Elite Décor", "🎪 Elite Coordination", "📋 Elite Management", "👥 Elite Staff", "🚗 Elite Transport"]],
    ["id" => 6065, "title" => "Diamond Venue", "subtitle" => "Diamond Venue Management", "image" => "./images/compvenue5.jpg", "price" => "PKR 2,000,000", "rating" => "5.0", "guests" => "300-5000 Guests", "capacity" => "Any Size", "timing" => "Full Day", "location" => "Worldwide", "type" => "Diamond Management", "description" => "Diamond venue management with ultimate luxury.", "features" => ["💎 Diamond Venue", "💎 Diamond Décor", "🎪 Diamond Coordination", "📋 Diamond Management", "👥 Diamond Staff", "🚗 Diamond Transport"]],
    ["id" => 6066, "title" => "Grand Venue", "subtitle" => "Grand Venue Management", "image" => "./images/compvenue6.jpg", "price" => "PKR 3,000,000", "rating" => "5.0", "guests" => "500-10000 Guests", "capacity" => "Any Size", "timing" => "Full Day +", "location" => "Worldwide", "type" => "Grand Management", "description" => "Grand venue management for the biggest weddings.", "features" => ["🏰 Grand Venue", "👑 Grand Décor", "🎪 Grand Coordination", "📋 Grand Management", "👥 Grand Staff", "🚗 Luxury Transport"]]
];

// ============================================
// SERVICE TITLES
// ============================================
$service_titles = [
    1 => "Wedding Planning",
    2 => "Décor & Styling",
    3 => "Photography & Films",
    4 => "Catering & Cuisine",
    5 => "Entertainment",
    6 => "Venue Management"
];

// ============================================
// LOGIC: Check if this is sub-product or main product
// ============================================
$is_sub_product = false;
$sub_product_data = null;
$parent_id = 0;

if ($product_id >= 1000) {
    $is_sub_product = true;
    $parent_id = (int)floor($product_id / 10);
    
    if (isset($sub_products[$parent_id])) {
        foreach ($sub_products[$parent_id] as $sp) {
            if ($sp['id'] == $product_id) {
                $sub_product_data = $sp;
                break;
            }
        }
    }
}

// ============================================
// PAGE DATA - FIXED BACKGROUND IMAGE LOGIC
// ============================================
if ($is_sub_product && $sub_product_data) {
    // SUB-PRODUCT PAGE
    $page_title    = $sub_product_data['title'];
    $page_subtitle = $sub_product_data['subtitle'];
    $page_guests   = $sub_product_data['guests'];
    $page_capacity = $sub_product_data['capacity'];
    $page_timing   = $sub_product_data['timing'];
    $page_location = $sub_product_data['location'];
    $page_type     = $sub_product_data['type'];
    
    // ✅ FIX: Sub-product ke liye background = us sub-product ki apni image
    $page_image = $sub_product_data['image'];
} else {
    // MAIN PRODUCT PAGE
    $main_data = isset($main_product_data[$product_id]) ? $main_product_data[$product_id] : [
        "title" => "Luxury Service",
        "subtitle" => "Premium Wedding Service",
        "image" => "./images/wedplaning.jpg",
        "guests" => "N/A",
        "capacity" => "N/A",
        "timing" => "N/A",
        "location" => "N/A",
        "type" => "N/A"
    ];
    $page_title    = $main_data['title'];
    $page_subtitle = $main_data['subtitle'];
    $page_guests   = $main_data['guests'];
    $page_capacity = $main_data['capacity'];
    $page_timing   = $main_data['timing'];
    $page_location = $main_data['location'];
    $page_type     = $main_data['type'];
    
    // ✅ Main product ke liye background = service ki banner image (detail.php se)
    if (isset($service_banners[$service_id])) {
        $page_image = $service_banners[$service_id];
    } else {
        $page_image = $main_data['image'];
    }
}

// Fallback image (agar file missing hai)
$fallback_for_service = isset($fallback_images[$product_id]) ? $fallback_images[$product_id] : (isset($service_banners[$service_id]) ? $service_banners[$service_id] : "./images/wedplaning.jpg");

$page_rating = "5.0";

$has_sub_products = isset($sub_products[$product_id]) && !empty($sub_products[$product_id]);
$sub_products_list = $has_sub_products ? $sub_products[$product_id] : [];

$main_title = $page_title;
$service_name = isset($service_titles[$service_id]) ? $service_titles[$service_id] : "Services";

$productTitle = addslashes($page_title);
$productImage = addslashes($page_image);
$fallbackImage = addslashes($fallback_for_service);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | Noor-E-Mahal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root { --gold: #d4af37; --gold-light: #f0d77b; --black: #0a0a0a; --white: #ffffff; --gray: #999999; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--black);
            color: var(--white);
            overflow-x: hidden;
        }
        a { text-decoration: none; }
        body {
            background-image: url('<?php echo $page_image; ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            transition: background-image 0.5s ease;
        }
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.82);
            z-index: -1;
        }
        .product-hero {
            min-height: 40vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 80px 20px 40px;
            background: transparent !important;
        }
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            padding: 40px 20px;
        }
        .hero-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(38px, 5vw, 58px);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 15px;
            color: #fff;
            text-shadow: 0 4px 40px rgba(0,0,0,0.8);
        }
        .hero-content .hero-sub {
            color: rgba(255, 255, 255, 0.85);
            font-size: clamp(16px, 1.8vw, 22px);
            max-width: 700px;
            margin: auto;
            line-height: 1.8;
            text-shadow: 0 2px 30px rgba(0,0,0,0.8);
        }
        .hero-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px 40px;
            margin-top: 25px;
            padding: 20px 30px;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(212,175,55,0.15);
        }
        .hero-detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #e0e0e0;
            font-size: 14px;
        }
        .hero-detail-item i {
            color: var(--gold);
            font-size: 18px;
            width: 20px;
        }
        .hero-detail-item span { color: #fff; font-weight: 500; }
        .hero-rating { margin-top: 15px; color: var(--gold); font-size: 18px; }
        .hero-rating span { color: #fff; font-size: 14px; margin-left: 10px; }
        .back-link { margin-top: 20px; }
        .back-link a { color: var(--gold); font-size: 14px; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .back-link a:hover { color: #fff; }
        .section-title { text-align: center; margin-bottom: 50px; }
        .section-title span { color: var(--gold); font-size: 13px; letter-spacing: 4px; text-transform: uppercase; font-weight: 600; }
        .section-title h2 { font-family: 'Playfair Display', serif; font-size: 40px; color: #fff; margin: 10px 0; }
        .section-title h2 span { color: var(--gold); position: relative; }
        .section-title p { color: #ccc; font-size: 16px; max-width: 600px; margin: 0 auto; }
        .products-section { padding: 60px 8% 100px; background: transparent !important; }
        .products-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; max-width: 1300px; margin: 0 auto; }
        .product-card {
            position: relative;
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .product-card:hover {
            transform: translateY(-15px);
            border-color: var(--gold);
            box-shadow: 0 30px 80px rgba(212, 175, 55, 0.15);
        }
        .product-image {
            position: relative;
            width: 100%;
            height: 220px;
            overflow: hidden;
            background: #111;
        }
        .product-image img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .card-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px 15px;
            padding: 12px 20px;
            background: rgba(0,0,0,0.3);
            border-bottom: 1px solid rgba(212,175,55,0.08);
        }
        .card-detail { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #bbb; }
        .card-detail i { color: var(--gold); font-size: 12px; width: 16px; }
        .card-detail strong { color: #fff; font-weight: 500; }
        .product-content { padding: 20px 25px 25px; }
        .product-content h3 { font-family: 'Playfair Display', serif; font-size: 20px; color: #fff; margin-bottom: 6px; }
        .product-content .product-desc { color: #aaa; font-size: 13px; line-height: 1.6; margin-bottom: 10px; }
        .product-rating { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; }
        .product-rating .stars { color: var(--gold); font-size: 14px; }
        .product-rating .rating-num { color: #fff; font-size: 13px; font-weight: 600; background: rgba(0,0,0,0.5); padding: 2px 10px; border-radius: 12px; }
        .product-features { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 15px; }
        .product-features span { background: rgba(212, 175, 55, 0.08); border: 1px solid rgba(212, 175, 55, 0.12); color: #ddd; font-size: 11px; padding: 3px 12px; border-radius: 12px; font-weight: 400; }
        .product-price { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700; color: var(--gold); margin-bottom: 15px; }
        .btn-book {
            display: block;
            width: 100%;
            padding: 14px 20px;
            background: linear-gradient(135deg, #d4af37, #f0d77b);
            color: #000;
            border: none;
            border-radius: 30px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            letter-spacing: 0.5px;
        }
        .btn-book i { margin-right: 8px; }
        .btn-book:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 10px 35px rgba(212, 175, 55, 0.5); }
        .live-booking {
            position: fixed;
            left: 30px;
            bottom: 30px;
            width: 340px;
            background: #121212;
            border: 1px solid rgba(212, 175, 55, 0.18);
            border-radius: 18px;
            padding: 18px;
            display: none;
            align-items: center;
            gap: 15px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.45);
            z-index: 99999;
            animation: popupIn 0.6s;
        }
        .live-booking.show { display: flex; }
        @keyframes popupIn { from { opacity: 0; transform: translateY(80px); } to { opacity: 1; transform: translateY(0); } }
        .live-image img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #d4af37; }
        .live-content { flex: 1; }
        .live-content h4 { color: #fff; font-size: 16px; margin-bottom: 4px; }
        .live-content p { color: #d4af37; font-size: 14px; margin-bottom: 6px; }
        .live-content span { font-size: 12px; color: #999; }
        .live-close { cursor: pointer; color: #777; transition: 0.3s; }
        .live-close:hover { color: #fff; }
        .recent-section { padding: 80px 0; background: transparent !important; }
        .recent-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-top: 50px; }
        .recent-card {
            background: rgba(20,20,20,0.6);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(212,175,55,0.15);
            transition: 0.35s;
            text-decoration: none;
            display: block;
        }
        .recent-card:hover { transform: translateY(-10px); border-color: #d4af37; box-shadow: 0 20px 40px rgba(212,175,55,0.18); }
        .recent-card img { width: 100%; height: 200px; object-fit: cover; transition: 0.5s; }
        .recent-card:hover img { transform: scale(1.08); }
        .recent-card h3 { padding: 20px; text-align: center; color: #fff; font-family: 'Playfair Display', serif; font-size: 18px; }
        .wishlist-area { margin: 25px 0; text-align: center; }
        .wishlist-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 14px 28px;
            background: rgba(20,20,20,0.6);
            border: 1px solid rgba(212,175,55,0.2);
            border-radius: 50px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.35s;
        }
        .wishlist-btn i { font-size: 20px; color: #d4af37; transition: 0.35s; }
        .wishlist-btn:hover { transform: translateY(-4px); border-color: #d4af37; box-shadow: 0 15px 35px rgba(212,175,55,0.15); }
        .wishlist-btn.active { background: #d4af37; color: #111; }
        .wishlist-btn.active i { color: #111; }
        .share-section { margin-top: 45px; padding: 35px; background: rgba(20,20,20,0.6); border-radius: 22px; border: 1px solid rgba(212,175,55,0.15); text-align: center; }
        .share-section h3 { font-family: 'Playfair Display', serif; font-size: 28px; color: #fff; margin-bottom: 25px; }
        .share-buttons { display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; }
        .share-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 18px;
            border-radius: 18px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: 0.35s;
            cursor: pointer;
            border: none;
        }
        .share-btn i { font-size: 28px; margin-bottom: 12px; }
        .whatsapp { background: #25D366; color: #fff; }
        .facebook { background: #1877F2; color: #fff; }
        .instagram { background: linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); color: #fff; }
        .email { background: #444; color: #fff; }
        .copy { background: #d4af37; color: #111; }
        .share-btn:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,0,0,0.3); }
        .luxury-footer {
            background: rgba(8, 8, 8, 0.9);
            padding: 60px 0 30px;
            border-top: 1px solid rgba(212,175,55,0.12);
            margin-top: 60px;
        }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 40px; margin-bottom: 40px; }
        .footer-box h2 { font-family: 'Playfair Display', serif; color: #d4af37; margin-bottom: 20px; font-size: 34px; }
        .footer-box h3 { color: #fff; margin-bottom: 20px; font-size: 22px; }
        .footer-box p { color: #bdbdbd; line-height: 1.8; }
        .footer-box ul { list-style: none; padding: 0; }
        .footer-box ul li { margin-bottom: 15px; color: #bdbdbd; }
        .footer-box ul li a { color: #bdbdbd; text-decoration: none; transition: 0.3s; }
        .footer-box ul li a:hover { color: #d4af37; padding-left: 8px; }
        .footer-social { display: flex; gap: 15px; margin-top: 25px; }
        .footer-social a { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; background: rgba(20,20,20,0.6); border-radius: 50%; color: #d4af37; transition: 0.35s; }
        .footer-social a:hover { background: #d4af37; color: #111; transform: translateY(-6px); }
        .footer-bottom { border-top: 1px solid rgba(212,175,55,0.12); padding-top: 25px; text-align: center; color: #999; font-size: 14px; }
        @media (max-width: 992px) { .products-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) {
            .products-grid { grid-template-columns: 1fr; }
            .section-title h2 { font-size: 30px; }
            .product-image { height: 180px; }
            .footer-grid { grid-template-columns: 1fr; }
            .live-booking { left: 15px; right: 15px; bottom: 15px; width: auto; }
            .share-buttons { grid-template-columns: repeat(2, 1fr); }
            .hero-details { flex-direction: column; align-items: center; gap: 10px; padding: 15px; }
            .card-details { grid-template-columns: 1fr; gap: 4px; }
        }
        @media (max-width: 576px) { .products-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<!-- ===== PRODUCT HERO ===== -->
<section class="product-hero">
    <div class="hero-content">
        <h1><?php echo $page_title; ?></h1>
        <p class="hero-sub"><?php echo $page_subtitle; ?></p>
        <div class="hero-details">
            <div class="hero-detail-item"><i class="fas fa-users"></i><span><?php echo $page_guests; ?></span></div>
            <div class="hero-detail-item"><i class="fas fa-expand"></i><span><?php echo $page_capacity; ?></span></div>
            <div class="hero-detail-item"><i class="fas fa-clock"></i><span><?php echo $page_timing; ?></span></div>
            <div class="hero-detail-item"><i class="fas fa-location-dot"></i><span><?php echo $page_location; ?></span></div>
            <div class="hero-detail-item"><i class="fas fa-tag"></i><span><?php echo $page_type; ?></span></div>
        </div>
        <div class="hero-rating">★★★★★ <span><?php echo $page_rating; ?> Rating</span></div>
        <div class="back-link"><a href="detail.php?id=<?php echo $service_id; ?>"><i class="fas fa-arrow-left"></i> Back to <?php echo $service_name; ?></a></div>
    </div>
</section>

<!-- ===== PRODUCT CARDS ===== -->
<section class="products-section">
    <div class="section-title">
        <span>Premium Selection</span>
        <h2>Choose Your <span>Luxury</span> Experience</h2>
        <p>Select from our premium <?php echo strtolower($main_title); ?> options for your special day.</p>
    </div>
    <div class="products-grid">
        <?php if ($has_sub_products && !empty($sub_products_list)): ?>
            <?php foreach ($sub_products_list as $sub): ?>
            <div class="product-card">
                <a href="product.php?product=<?php echo $sub['id']; ?>&service=<?php echo $service_id; ?>" style="text-decoration:none; color:inherit; display:block;">
                    <div class="product-image">
                        <img src="<?php echo $sub['image']; ?>" alt="<?php echo $sub['title']; ?>" loading="lazy" onerror="this.onerror=null; this.src='<?php echo $fallbackImage; ?>';">
                    </div>
                    <div class="card-details">
                        <div class="card-detail"><i class="fas fa-users"></i><strong><?php echo $sub['guests']; ?></strong></div>
                        <div class="card-detail"><i class="fas fa-expand"></i><strong><?php echo $sub['capacity']; ?></strong></div>
                        <div class="card-detail"><i class="fas fa-clock"></i><strong><?php echo $sub['timing']; ?></strong></div>
                        <div class="card-detail"><i class="fas fa-location-dot"></i><strong><?php echo $sub['location']; ?></strong></div>
                    </div>
                    <div class="product-content">
                        <h3><?php echo $sub['title']; ?></h3>
                        <p class="product-desc"><?php echo substr($sub['description'], 0, 80); ?>...</p>
                        <div class="product-rating"><span class="stars">★★★★★</span><span class="rating-num"><?php echo $sub['rating']; ?></span></div>
                        <div class="product-features">
                            <?php foreach (array_slice($sub['features'], 0, 3) as $feature): ?>
                                <span><?php echo $feature; ?></span>
                            <?php endforeach; ?>
                            <?php if (count($sub['features']) > 3): ?>
                                <span>+<?php echo count($sub['features']) - 3; ?> more</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-price"><?php echo $sub['price']; ?></div>
                    </div>
                </a>
                <div style="padding: 0 25px 25px;">
                    <a href="booking.php?product=<?php echo $sub['id']; ?>&service=<?php echo $service_id; ?>" class="btn-book"><i class="fas fa-calendar-check"></i> Book Now</a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1/-1; text-align: center; padding: 60px; color: #999;">
                <i class="fas fa-box-open" style="font-size: 48px; color: var(--gold); margin-bottom: 20px;"></i>
                <h3>No options available</h3>
                <p>Please check back later for updates.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ===== RECENTLY VIEWED ===== -->
<section class="recent-section">
    <div class="container" style="max-width:1300px; margin:0 auto; padding:0 20px;">
        <div class="section-title">
            <span>Your History</span>
            <h2>Recently Viewed</h2>
            <p>Continue exploring the wedding venues you recently visited.</p>
        </div>
        <div class="recent-grid" id="recentGrid"></div>
    </div>
</section>

<!-- ===== WISHLIST ===== -->
<div class="container" style="max-width:1300px; margin:0 auto; padding:0 20px;">
    <div class="wishlist-area">
        <button id="wishlistBtn" class="wishlist-btn"><i class="far fa-heart"></i><span>Add to Wishlist</span></button>
    </div>
</div>

<!-- ===== SHARE SECTION ===== -->
<div class="container" style="max-width:1300px; margin:0 auto; padding:0 20px;">
    <div class="share-section">
        <h3>Share This Venue</h3>
        <div class="share-buttons">
            <a href="#" class="share-btn whatsapp"><i class="fab fa-whatsapp"></i><span>WhatsApp</span></a>
            <a href="#" class="share-btn facebook"><i class="fab fa-facebook-f"></i><span>Facebook</span></a>
            <a href="#" class="share-btn instagram"><i class="fab fa-instagram"></i><span>Instagram</span></a>
            <a href="#" class="share-btn email"><i class="fas fa-envelope"></i><span>Email</span></a>
            <button id="copyLink" class="share-btn copy"><i class="fas fa-link"></i><span>Copy Link</span></button>
        </div>
    </div>
</div>

<!-- ===== LIVE BOOKING POPUP ===== -->
<div class="live-booking" id="liveBooking">
    <div class="live-image"><img id="bookingImage" src="images/users/user1.jpg" alt="User"></div>
    <div class="live-content">
        <h4 id="bookingName">Ahmed Khan</h4>
        <p id="bookingText">Booked Royal Ballroom</p>
        <span id="bookingTime">2 minutes ago</span>
    </div>
    <div class="live-close" onclick="closeBooking()"><i class="fas fa-times"></i></div>
</div>

<!-- ===== FOOTER ===== -->
<footer class="luxury-footer">
    <div class="container" style="max-width:1300px; margin:0 auto; padding:0 20px;">
        <div class="footer-grid">
            <div class="footer-box">
                <h2>Noor-E-Mahal</h2>
                <p>Luxury Wedding Planner creating unforgettable wedding experiences with elegance, creativity and perfection.</p>
                <div class="footer-social">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-box">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-box">
                <h3>Contact</h3>
                <ul>
                    <li><i class="fas fa-phone"></i> +92 300 1234567</li>
                    <li><i class="fas fa-envelope"></i> info@nooremahal.com</li>
                    <li><i class="fas fa-location-dot"></i> Karachi, Pakistan</li>
                </ul>
            </div>
            <div class="footer-box">
                <h3>Newsletter</h3>
                <p>Subscribe to receive wedding tips and exclusive offers.</p>
                <form class="newsletter" style="display:flex; flex-direction:column; gap:15px; margin-top:20px;">
                    <input type="email" placeholder="Enter Email" style="padding:14px; background:rgba(20,20,20,0.6); border:1px solid rgba(212,175,55,0.15); border-radius:12px; color:#fff;">
                    <button style="padding:14px; background:#d4af37; border:none; border-radius:50px; font-weight:700; cursor:pointer; transition:0.35s;">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom"><p>© <?php echo date('Y'); ?> Noor-E-Mahal. All Rights Reserved.</p></div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookings = [
        { name: "Ahmed Khan", text: "Booked Royal Ballroom", time: "2 minutes ago", image: "images/users/user1.jpg" },
        { name: "Fatima Ali", text: "Reserved Luxury Hall", time: "5 minutes ago", image: "images/users/user2.jpg" },
        { name: "Usman Malik", text: "Booked Outdoor Garden", time: "8 minutes ago", image: "images/users/user3.jpg" },
        { name: "Ayesha Noor", text: "Reserved Premium Catering", time: "12 minutes ago", image: "images/users/user4.jpg" },
        { name: "Hassan Ahmed", text: "Booked Wedding Decoration", time: "18 minutes ago", image: "images/users/user5.jpg" }
    ];
    let index = 0;
    const liveBooking = document.getElementById('liveBooking');
    function showBooking() {
        if (!liveBooking) return;
        const b = bookings[index];
        document.getElementById('bookingName').innerHTML = b.name;
        document.getElementById('bookingText').innerHTML = b.text;
        document.getElementById('bookingTime').innerHTML = b.time;
        document.getElementById('bookingImage').src = b.image;
        liveBooking.classList.add('show');
        liveBooking.style.display = 'flex';
        index++;
        if (index >= bookings.length) index = 0;
        setTimeout(() => { liveBooking.classList.remove('show'); liveBooking.style.display = 'none'; }, 5000);
    }
    window.closeBooking = function() {
        const el = document.getElementById('liveBooking');
        if (el) { el.classList.remove('show'); el.style.display = 'none'; }
    };
    setTimeout(showBooking, 1000);
    setInterval(showBooking, 10000);
    const currentProduct = {
        title: "<?php echo $productTitle; ?>",
        image: "<?php echo $productImage; ?>",
        link: window.location.href
    };
    const fallbackImage = "<?php echo $fallbackImage; ?>";
    let viewed = JSON.parse(localStorage.getItem('recentProducts')) || [];
    viewed = viewed.filter(p => p.title !== currentProduct.title);
    viewed.unshift(currentProduct);
    if (viewed.length > 6) viewed.pop();
    localStorage.setItem('recentProducts', JSON.stringify(viewed));
    const grid = document.getElementById('recentGrid');
    if (grid) {
        grid.innerHTML = '';
        viewed.forEach(item => {
            grid.innerHTML += `<a href="${item.link}" class="recent-card"><img src="${item.image}" alt="${item.title}" onerror="this.onerror=null; this.src='${fallbackImage}';"><h3>${item.title}</h3></a>`;
        });
    }
    const wishBtn = document.getElementById('wishlistBtn');
    const productTitle = "<?php echo $productTitle; ?>";
    if (wishBtn) {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        if (wishlist.includes(productTitle)) {
            wishBtn.classList.add('active');
            wishBtn.innerHTML = '<i class="fas fa-heart"></i><span>Saved</span>';
        }
        wishBtn.onclick = function() {
            if (!wishlist.includes(productTitle)) {
                wishlist.push(productTitle);
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                wishBtn.classList.add('active');
                wishBtn.innerHTML = '<i class="fas fa-heart"></i><span>Saved</span>';
            } else {
                wishlist = wishlist.filter(item => item !== productTitle);
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                wishBtn.classList.remove('active');
                wishBtn.innerHTML = '<i class="far fa-heart"></i><span>Add to Wishlist</span>';
            }
        };
    }
    const pageURL = window.location.href;
    document.querySelector('.whatsapp').href = "https://wa.me/?text=" + encodeURIComponent(pageURL);
    document.querySelector('.facebook').href = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(pageURL);
    document.querySelector('.email').href = "mailto:?subject=Check this Wedding Venue&body=" + encodeURIComponent(pageURL);
    document.querySelector('.instagram').onclick = function(e) { e.preventDefault(); alert("Instagram direct sharing is not supported. Please copy the link and share it."); };
    document.getElementById('copyLink').onclick = function() {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(pageURL).then(() => {
                this.innerHTML = '<i class="fas fa-check"></i><span>Copied</span>';
                setTimeout(() => { this.innerHTML = '<i class="fas fa-link"></i><span>Copy Link</span>'; }, 2000);
            });
        } else {
            const input = document.createElement('input');
            input.value = pageURL;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            this.innerHTML = '<i class="fas fa-check"></i><span>Copied</span>';
            setTimeout(() => { this.innerHTML = '<i class="fas fa-link"></i><span>Copy Link</span>'; }, 2000);
        }
    };
});
</script>
</body>
</html>