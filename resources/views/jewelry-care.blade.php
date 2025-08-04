@extends('layout.header')

@section('title', 'Jewelry Care Guide - Cleaning & Maintenance Tips | SK Ornaments')
@section('description', 'Learn how to properly clean and maintain your jewelry with expert care tips from SK Ornaments. Keep your precious pieces looking beautiful for years.')
@section('keywords', 'jewelry care, jewelry cleaning, jewelry maintenance, diamond care, gold jewelry care, silver jewelry care')

@section('og_title', 'Jewelry Care Guide - SK Ornaments')
@section('og_description', 'Expert tips for cleaning and maintaining your precious jewelry collection.')

<style>
    .care-page {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .care-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 0;
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .care-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .care-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .care-content {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .care-section {
        background: white;
        border-radius: 15px;
        padding: 3rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1.5rem;
        border-bottom: 3px solid #667eea;
        padding-bottom: 0.5rem;
    }
    
    .subsection-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin: 2rem 0 1rem;
        padding-left: 1rem;
        border-left: 4px solid #667eea;
    }
    
    .care-text {
        font-size: 1rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 1.5rem;
    }
    
    .care-list {
        margin: 1.5rem 0;
        padding-left: 2rem;
    }
    
    .care-list li {
        margin-bottom: 0.8rem;
        line-height: 1.6;
        color: #555;
    }
    
    .highlight-box {
        background: #f8f9fa;
        border-left: 4px solid #667eea;
        padding: 1.5rem;
        margin: 1.5rem 0;
        border-radius: 0 10px 10px 0;
    }
    
    .highlight-box h4 {
        color: #667eea;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .warning-box {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 1.5rem;
        margin: 1.5rem 0;
        border-radius: 0 10px 10px 0;
    }
    
    .warning-box h4 {
        color: #856404;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .care-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .care-card {
        background: #f8f9fa;
        padding: 2rem;
        border-radius: 15px;
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }
    
    .care-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .care-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        color: white;
        font-size: 1.5rem;
    }
    
    .care-card h4 {
        color: #333;
        font-size: 1.3rem;
        margin-bottom: 1rem;
    }
    
    .care-card p {
        color: #666;
        line-height: 1.6;
    }
    
    .contact-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-top: 2rem;
        text-align: center;
    }
    
    .contact-info h3 {
        margin-bottom: 1rem;
    }
    
    .contact-info p {
        margin-bottom: 0.5rem;
    }
    
    .contact-info a {
        color: white;
        text-decoration: underline;
    }
    
    @media (max-width: 768px) {
        .care-hero h1 {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .care-section {
            padding: 2rem;
        }
        
        .care-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Jewelry Care Page -->
<div class="care-page">
    <!-- Hero Section -->
    <div class="care-hero">
        <div class="container">
            <h1>Jewelry Care Guide</h1>
            <p>Learn how to properly clean and maintain your precious jewelry to keep it looking beautiful for generations.</p>
        </div>
    </div>

    <div class="container care-content">
        <!-- General Care Tips -->
        <div class="care-section">
            <h2 class="section-title">General Jewelry Care Tips</h2>
            <p class="care-text">
                Proper jewelry care is essential to maintain the beauty and value of your precious pieces. Follow these general guidelines to keep your jewelry looking its best.
            </p>
            
            <div class="care-grid">
                <div class="care-card">
                    <div class="care-icon">
                        <i class="fas fa-hand-sparkles"></i>
                    </div>
                    <h4>Clean Hands</h4>
                    <p>Always wash your hands before handling jewelry to avoid transferring oils and dirt to your precious pieces.</p>
                </div>
                
                <div class="care-card">
                    <div class="care-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <h4>Proper Storage</h4>
                    <p>Store jewelry in a clean, dry place away from direct sunlight and extreme temperatures.</p>
                </div>
                
                <div class="care-card">
                    <div class="care-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h4>Regular Maintenance</h4>
                    <p>Have your jewelry professionally cleaned and inspected at least once a year.</p>
                </div>
            </div>
        </div>

        <!-- Diamond Care -->
        <div class="care-section">
            <h2 class="section-title">Diamond Jewelry Care</h2>
            
            <h3 class="subsection-title">Cleaning Diamonds</h3>
            <p class="care-text">
                Diamonds are the hardest natural substance, but they still require proper care to maintain their brilliance.
            </p>
            
            <ul class="care-list">
                <li>Clean diamonds regularly with warm soapy water and a soft brush</li>
                <li>Use a mild dish soap and lukewarm water</li>
                <li>Rinse thoroughly and dry with a soft, lint-free cloth</li>
                <li>Avoid harsh chemicals and ultrasonic cleaners unless recommended</li>
                <li>Have diamonds professionally cleaned annually</li>
            </ul>
            
            <div class="highlight-box">
                <h4>💎 Diamond Care Tips</h4>
                <ul class="care-list">
                    <li>Diamonds can scratch other diamonds, so store them separately</li>
                    <li>Avoid wearing diamond jewelry during physical activities</li>
                    <li>Remove diamond jewelry before applying lotions or perfumes</li>
                    <li>Check diamond settings regularly for loose stones</li>
                </ul>
            </div>
        </div>

        <!-- Gold Jewelry Care -->
        <div class="care-section">
            <h2 class="section-title">Gold Jewelry Care</h2>
            
            <h3 class="subsection-title">Cleaning Gold Jewelry</h3>
            <p class="care-text">
                Gold jewelry requires gentle cleaning to maintain its luster and prevent damage.
            </p>
            
            <ul class="care-list">
                <li>Clean with warm soapy water and a soft cloth</li>
                <li>Use a mild dish soap or specialized jewelry cleaner</li>
                <li>Gently scrub with a soft-bristled toothbrush if needed</li>
                <li>Rinse thoroughly and dry completely</li>
                <li>Polish with a jewelry polishing cloth</li>
            </ul>
            
            <div class="warning-box">
                <h4>⚠️ Gold Care Warnings</h4>
                <ul class="care-list">
                    <li>Never use harsh chemicals or abrasive cleaners</li>
                    <li>Avoid chlorine, which can damage gold</li>
                    <li>Remove gold jewelry before swimming or exercising</li>
                    <li>Store gold jewelry separately to prevent scratching</li>
                </ul>
            </div>
        </div>

        <!-- Silver Jewelry Care -->
        <div class="care-section">
            <h2 class="section-title">Silver Jewelry Care</h2>
            
            <h3 class="subsection-title">Preventing Tarnish</h3>
            <p class="care-text">
                Silver jewelry naturally tarnishes over time, but proper care can slow this process significantly.
            </p>
            
            <ul class="care-list">
                <li>Store silver in airtight containers or anti-tarnish bags</li>
                <li>Keep silver away from rubber, wool, and certain papers</li>
                <li>Wear silver jewelry regularly to prevent tarnish</li>
                <li>Clean silver immediately after exposure to chemicals</li>
                <li>Use silver polishing cloths for regular maintenance</li>
            </ul>
            
            <h3 class="subsection-title">Cleaning Silver</h3>
            <ul class="care-list">
                <li>Use specialized silver cleaning solutions</li>
                <li>Clean with warm water and mild soap</li>
                <li>Use a soft cloth or brush for gentle cleaning</li>
                <li>Rinse thoroughly and dry completely</li>
                <li>Polish with a silver polishing cloth</li>
            </ul>
        </div>

        <!-- Pearl Care -->
        <div class="care-section">
            <h2 class="section-title">Pearl Jewelry Care</h2>
            
            <h3 class="subsection-title">Pearl Maintenance</h3>
            <p class="care-text">
                Pearls are delicate and require special care to maintain their beauty and luster.
            </p>
            
            <ul class="care-list">
                <li>Wipe pearls with a soft, damp cloth after each wear</li>
                <li>Store pearls in a soft pouch or cloth</li>
                <li>Keep pearls away from direct sunlight and heat</li>
                <li>Apply perfumes and lotions before wearing pearls</li>
                <li>Have pearls restrung annually if worn frequently</li>
            </ul>
            
            <div class="warning-box">
                <h4>⚠️ Pearl Care Warnings</h4>
                <ul class="care-list">
                    <li>Never use harsh chemicals or ultrasonic cleaners</li>
                    <li>Avoid exposing pearls to extreme temperatures</li>
                    <li>Don't store pearls in plastic bags</li>
                    <li>Remove pearls before exercising or swimming</li>
                </ul>
            </div>
        </div>

        <!-- Storage Guidelines -->
        <div class="care-section">
            <h2 class="section-title">Proper Jewelry Storage</h2>
            
            <h3 class="subsection-title">Storage Best Practices</h3>
            <p class="care-text">
                Proper storage is crucial for maintaining your jewelry's condition and preventing damage.
            </p>
            
            <div class="care-grid">
                <div class="care-card">
                    <div class="care-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h4>Jewelry Boxes</h4>
                    <p>Use lined jewelry boxes with separate compartments to prevent scratching and tangling.</p>
                </div>
                
                <div class="care-card">
                    <div class="care-icon">
                        <i class="fas fa-temperature-low"></i>
                    </div>
                    <h4>Temperature Control</h4>
                    <p>Store jewelry in a cool, dry place away from direct sunlight and extreme temperatures.</p>
                </div>
                
                <div class="care-card">
                    <div class="care-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Security</h4>
                    <p>Keep valuable jewelry in a secure location, such as a safe or safety deposit box.</p>
                </div>
            </div>
            
            <h3 class="subsection-title">Storage by Material</h3>
            <ul class="care-list">
                <li><strong>Diamonds:</strong> Store separately to prevent scratching</li>
                <li><strong>Gold:</strong> Keep in soft pouches or lined compartments</li>
                <li><strong>Silver:</strong> Use anti-tarnish bags or cloth</li>
                <li><strong>Pearls:</strong> Store in soft cloth pouches</li>
                <li><strong>Gemstones:</strong> Keep away from direct light and heat</li>
            </ul>
        </div>

        <!-- Professional Care -->
        <div class="care-section">
            <h2 class="section-title">Professional Jewelry Care</h2>
            
            <h3 class="subsection-title">When to Seek Professional Help</h3>
            <p class="care-text">
                While regular home care is important, some situations require professional attention.
            </p>
            
            <ul class="care-list">
                <li>Annual professional cleaning and inspection</li>
                <li>Loose or damaged settings</li>
                <li>Severe tarnishing or discoloration</li>
                <li>Broken clasps or chains</li>
                <li>Stone replacement or repair</li>
                <li>Resizing rings or bracelets</li>
            </ul>
            
            <div class="highlight-box">
                <h4>🔧 Professional Services</h4>
                <p>SK Ornaments offers professional jewelry cleaning, repair, and maintenance services. Our expert jewelers can help restore your jewelry to its original beauty and ensure it's in perfect condition.</p>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="contact-info">
            <h3>Need Professional Jewelry Care?</h3>
            <p>Our expert jewelers are here to help with cleaning, repair, and maintenance services.</p>
            <p><strong>Email:</strong> <a href="mailto:care@skornaments.com">care@skornaments.com</a></p>
            <p><strong>Phone:</strong> <a href="tel:8450999000">+91 8450999000</a></p>
            <p><strong>WhatsApp:</strong> <a href="https://wa.me/918450999000">+91 8450999000</a></p>
            <p><strong>Visit Our Store:</strong> 201, Bansari Bhuvan, Shop No.11, Tamil Sangam Marg, Opp. Union Bank, Sion (E), Mumbai - 400 022</p>
        </div>
    </div>
</div>

<!-- Structured Data for Jewelry Care -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Jewelry Care Guide - SK Ornaments",
    "description": "Comprehensive jewelry care guide with cleaning and maintenance tips for all types of jewelry.",
    "url": "{{ url('/jewelry-care') }}",
    "publisher": {
        "@type": "Organization",
        "name": "SK Ornaments",
        "url": "{{ url('/') }}"
    },
    "dateModified": "2025-02-15",
    "mainEntity": {
        "@type": "Article",
        "name": "Jewelry Care Guide",
        "description": "Expert tips for cleaning and maintaining jewelry including diamonds, gold, silver, and pearls.",
        "author": {
            "@type": "Organization",
            "name": "SK Ornaments"
        },
        "datePublished": "2025-02-15",
        "dateModified": "2025-02-15"
    }
}
</script>

@include('layout.footer')