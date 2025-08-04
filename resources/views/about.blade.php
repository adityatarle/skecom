@extends('layout.header')

@section('title', 'About Us - SK Ornaments | Premium Jewelry Store | Diamond Rings, Gold Jewelry')
@section('description', 'Discover the story behind SK Ornaments - your trusted jewelry destination since 1995. Premium diamond rings, gold jewelry, and designer pieces with certified quality and exceptional service.')
@section('keywords', 'about SK Ornaments, jewelry store history, diamond jewelry, gold jewelry, premium jewelry, certified diamonds, jewelry craftsmanship')

@section('og_title', 'About SK Ornaments - Premium Jewelry Store')
@section('og_description', 'Discover the story behind SK Ornaments - your trusted jewelry destination since 1995. Premium diamond rings, gold jewelry, and designer pieces.')

<style>
    .about-page {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .about-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4rem 0;
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .about-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .about-hero p {
        font-size: 1.2rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .about-content {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .about-section {
        background: white;
        border-radius: 15px;
        padding: 3rem;
        margin-bottom: 3rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 2px;
    }
    
    .story-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: center;
    }
    
    .story-text h3 {
        font-size: 1.8rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1.5rem;
    }
    
    .story-text p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #666;
        margin-bottom: 1.5rem;
    }
    
    .story-image {
        text-align: center;
    }
    
    .story-image img {
        max-width: 100%;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }
    
    .value-card {
        background: #f8f9fa;
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
        transition: all 0.3s ease;
        border-left: 4px solid #667eea;
    }
    
    .value-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .value-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 2rem;
    }
    
    .value-card h4 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
    }
    
    .value-card p {
        color: #666;
        line-height: 1.6;
    }
    
    .stats-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4rem 0;
        margin: 3rem 0;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        text-align: center;
    }
    
    .stat-item h3 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stat-item p {
        font-size: 1.1rem;
        opacity: 0.9;
    }
    
    .team-section {
        text-align: center;
    }
    
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }
    
    .team-card {
        background: #f8f9fa;
        padding: 2rem;
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .team-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }
    
    .team-card h4 {
        font-size: 1.3rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .team-card p {
        color: #667eea;
        font-weight: 500;
        margin-bottom: 1rem;
    }
    
    .team-card .description {
        color: #666;
        line-height: 1.6;
    }
    
    .certifications {
        background: #f8f9fa;
        padding: 3rem;
        border-radius: 15px;
        margin-top: 3rem;
    }
    
    .cert-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .cert-item {
        text-align: center;
        padding: 1.5rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .cert-icon {
        font-size: 3rem;
        color: #667eea;
        margin-bottom: 1rem;
    }
    
    .cert-item h5 {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .cert-item p {
        color: #666;
        font-size: 0.9rem;
    }
    
    @media (max-width: 768px) {
        .story-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .about-hero h1 {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .about-section {
            padding: 2rem;
        }
    }
</style>

<!-- About Us Page -->
<div class="about-page">
    <!-- Hero Section -->
    <div class="about-hero">
        <div class="container">
            <h1>About SK Ornaments</h1>
            <p>Your trusted destination for premium jewelry since 1995. We bring you the finest collection of diamond rings, gold jewelry, and designer pieces with unmatched quality and service.</p>
        </div>
    </div>

    <div class="container about-content">
        <!-- Our Story Section -->
        <div class="about-section">
            <h2 class="section-title">Our Story</h2>
            <div class="story-content">
                <div class="story-text">
                    <h3>A Legacy of Excellence</h3>
                    <p>Founded in 1995, SK Ornaments has been at the forefront of the jewelry industry, bringing you the most exquisite collection of fine jewelry. What started as a small family business has grown into one of Mumbai's most trusted jewelry destinations.</p>
                    
                    <p>Our journey began with a simple vision: to provide customers with not just beautiful jewelry, but pieces that tell stories, celebrate milestones, and become family heirlooms. Over the years, we've maintained our commitment to quality, craftsmanship, and customer satisfaction.</p>
                    
                    <p>Today, SK Ornaments stands as a symbol of trust, quality, and excellence in the jewelry industry. We continue to innovate and expand our collection while staying true to our core values of integrity, quality, and customer-first approach.</p>
                </div>
                <div class="story-image">
                    <img src="{{ asset('assets/img/about/store-front.jpg') }}" alt="SK Ornaments Store Front" onerror="this.src='https://via.placeholder.com/500x400/667eea/ffffff?text=SK+Ornaments'">
                </div>
            </div>
        </div>

        <!-- Our Values Section -->
        <div class="about-section">
            <h2 class="section-title">Our Values</h2>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-gem"></i>
                    </div>
                    <h4>Quality Assurance</h4>
                    <p>Every piece in our collection undergoes rigorous quality checks. We work only with certified diamonds and precious metals to ensure you get the best value for your investment.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4>Trust & Transparency</h4>
                    <p>We believe in complete transparency in our business practices. From pricing to certification, we provide all the information you need to make informed decisions.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4>Customer First</h4>
                    <p>Your satisfaction is our priority. We provide personalized service, expert guidance, and after-sales support to ensure you have a wonderful shopping experience.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h4>Excellence</h4>
                    <p>We strive for excellence in everything we do - from selecting the finest materials to crafting beautiful designs and providing exceptional service.</p>
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="stats-section">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-item">
                        <h3>25+</h3>
                        <p>Years of Excellence</p>
                    </div>
                    <div class="stat-item">
                        <h3>10,000+</h3>
                        <p>Happy Customers</p>
                    </div>
                    <div class="stat-item">
                        <h3>5000+</h3>
                        <p>Jewelry Pieces</p>
                    </div>
                    <div class="stat-item">
                        <h3>100%</h3>
                        <p>Certified Diamonds</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Team Section -->
        <div class="about-section team-section">
            <h2 class="section-title">Our Expert Team</h2>
            <div class="team-grid">
                <div class="team-card">
                    <div class="team-image">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h4>Rajesh Kumar</h4>
                    <p>Founder & CEO</p>
                    <div class="description">
                        With over 30 years of experience in the jewelry industry, Rajesh leads our company with vision and expertise.
                    </div>
                </div>
                
                <div class="team-card">
                    <div class="team-image">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h4>Priya Sharma</h4>
                    <p>Head of Design</p>
                    <div class="description">
                        A certified gemologist and designer, Priya creates stunning pieces that blend tradition with contemporary style.
                    </div>
                </div>
                
                <div class="team-card">
                    <div class="team-image">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <h4>Amit Patel</h4>
                    <p>Quality Manager</p>
                    <div class="description">
                        Ensures every piece meets our high standards of quality and certification requirements.
                    </div>
                </div>
                
                <div class="team-card">
                    <div class="team-image">
                        <i class="fas fa-user-headset"></i>
                    </div>
                    <h4>Neha Singh</h4>
                    <p>Customer Service Head</p>
                    <div class="description">
                        Dedicated to providing exceptional customer service and ensuring your complete satisfaction.
                    </div>
                </div>
            </div>
        </div>

        <!-- Certifications Section -->
        <div class="about-section">
            <h2 class="section-title">Our Certifications & Standards</h2>
            <div class="certifications">
                <div class="cert-grid">
                    <div class="cert-item">
                        <div class="cert-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h5>BIS Hallmark</h5>
                        <p>All our gold jewelry is BIS hallmarked for purity and quality assurance.</p>
                    </div>
                    
                    <div class="cert-item">
                        <div class="cert-icon">
                            <i class="fas fa-diamond"></i>
                        </div>
                        <h5>GIA Certified</h5>
                        <p>All diamonds are GIA certified with detailed grading reports.</p>
                    </div>
                    
                    <div class="cert-item">
                        <div class="cert-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5>ISO 9001:2015</h5>
                        <p>Certified for quality management systems and processes.</p>
                    </div>
                    
                    <div class="cert-item">
                        <div class="cert-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h5>Responsible Sourcing</h5>
                        <p>Committed to ethical sourcing and responsible business practices.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Structured Data for About Page -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "SK Ornaments",
    "description": "Premium jewelry store offering diamond rings, gold jewelry, silver jewelry, and designer pieces since 1995",
    "url": "{{ url('/about') }}",
    "logo": "{{ asset('assets/img/logo/logo.jpg') }}",
    "image": "{{ asset('assets/img/logo/logo.jpg') }}",
    "foundingDate": "1995",
    "telephone": "+91-8450999000",
    "email": "customer.service@skornaments.com",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "201, Bansari Bhuvan, Shop No.11, Tamil Sangam Marg, Opp. Union Bank, Sion (E)",
        "addressLocality": "Mumbai",
        "addressRegion": "Maharashtra",
        "postalCode": "400022",
        "addressCountry": "IN"
    },
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": "19.0760",
        "longitude": "72.8777"
    },
    "openingHours": "Mo-Su 10:00-20:00",
    "priceRange": "₹₹₹",
    "paymentAccepted": "Cash, Credit Card, Debit Card, UPI, Net Banking",
    "currenciesAccepted": "INR",
    "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "Jewelry Collection",
        "itemListElement": [
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "Product",
                    "name": "Diamond Rings"
                }
            },
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "Product",
                    "name": "Gold Jewelry"
                }
            },
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "Product",
                    "name": "Silver Jewelry"
                }
            }
        ]
    },
    "sameAs": [
        "https://www.facebook.com/skornaments",
        "https://www.instagram.com/skornaments",
        "https://www.youtube.com/skornaments"
    ]
}
</script>

@include('layout.footer')