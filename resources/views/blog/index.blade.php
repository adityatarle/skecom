@extends('layout.header')

@section('title', 'Jewelry Blog - Tips, Trends & Care Guide | SK Ornaments')
@section('description', 'Discover jewelry care tips, latest trends, and expert advice from SK Ornaments. Read our blog for jewelry maintenance, styling tips, and industry insights.')
@section('keywords', 'jewelry blog, jewelry care, jewelry trends, diamond care, gold jewelry tips, SK Ornaments blog')

@section('og_title', 'Jewelry Blog - SK Ornaments')
@section('og_description', 'Discover jewelry care tips, latest trends, and expert advice from SK Ornaments.')

<style>
    .blog-page {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .blog-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 0;
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .blog-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .blog-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .blog-content {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }
    
    .blog-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .blog-image {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }
    
    .blog-content-card {
        padding: 2rem;
    }
    
    .blog-category {
        color: #667eea;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }
    
    .blog-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1rem;
        line-height: 1.4;
    }
    
    .blog-excerpt {
        color: #666;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    .blog-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #999;
        font-size: 0.9rem;
    }
    
    .read-more {
        background: #667eea;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .read-more:hover {
        background: #5a6fd8;
        color: white;
        text-decoration: none;
    }
    
    .coming-soon {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .coming-soon h2 {
        color: #333;
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    
    .coming-soon p {
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }
    
    .newsletter-signup {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem;
        border-radius: 15px;
        text-align: center;
        margin-top: 3rem;
    }
    
    .newsletter-signup h3 {
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }
    
    .newsletter-form {
        display: flex;
        max-width: 400px;
        margin: 0 auto;
        gap: 1rem;
    }
    
    .newsletter-input {
        flex: 1;
        padding: 0.75rem 1rem;
        border: none;
        border-radius: 25px;
        outline: none;
    }
    
    .newsletter-btn {
        background: white;
        color: #667eea;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .newsletter-btn:hover {
        background: #f8f9fa;
    }
    
    @media (max-width: 768px) {
        .blog-hero h1 {
            font-size: 2rem;
        }
        
        .blog-grid {
            grid-template-columns: 1fr;
        }
        
        .newsletter-form {
            flex-direction: column;
        }
    }
</style>

<!-- Blog Page -->
<div class="blog-page">
    <!-- Hero Section -->
    <div class="blog-hero">
        <div class="container">
            <h1>Jewelry Blog</h1>
            <p>Discover expert tips, latest trends, and care guides for your precious jewelry collection.</p>
        </div>
    </div>

    <div class="container blog-content">
        <!-- Coming Soon Section -->
        <div class="coming-soon">
            <h2>Coming Soon!</h2>
            <p>We're working on creating amazing content for you. Our blog will feature:</p>
            
            <div class="blog-grid">
                <div class="blog-card">
                    <div class="blog-image">
                        <i class="fas fa-gem"></i>
                    </div>
                    <div class="blog-content-card">
                        <div class="blog-category">Jewelry Care</div>
                        <h3 class="blog-title">How to Clean and Maintain Your Jewelry</h3>
                        <p class="blog-excerpt">Learn the best practices for cleaning and storing your precious jewelry to keep it looking beautiful for years to come.</p>
                        <div class="blog-meta">
                            <span>Coming Soon</span>
                            <a href="#" class="read-more">Read More</a>
                        </div>
                    </div>
                </div>
                
                <div class="blog-card">
                    <div class="blog-image">
                        <i class="fas fa-diamond"></i>
                    </div>
                    <div class="blog-content-card">
                        <div class="blog-category">Diamond Guide</div>
                        <h3 class="blog-title">Understanding the 4 C's of Diamonds</h3>
                        <p class="blog-excerpt">A comprehensive guide to cut, color, clarity, and carat weight - the essential factors that determine diamond quality.</p>
                        <div class="blog-meta">
                            <span>Coming Soon</span>
                            <a href="#" class="read-more">Read More</a>
                        </div>
                    </div>
                </div>
                
                <div class="blog-card">
                    <div class="blog-image">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="blog-content-card">
                        <div class="blog-category">Wedding Jewelry</div>
                        <h3 class="blog-title">Choosing the Perfect Engagement Ring</h3>
                        <p class="blog-excerpt">Expert tips on selecting the ideal engagement ring that matches your partner's style and personality.</p>
                        <div class="blog-meta">
                            <span>Coming Soon</span>
                            <a href="#" class="read-more">Read More</a>
                        </div>
                    </div>
                </div>
                
                <div class="blog-card">
                    <div class="blog-image">
                        <i class="fas fa-trending-up"></i>
                    </div>
                    <div class="blog-content-card">
                        <div class="blog-category">Trends</div>
                        <h3 class="blog-title">2025 Jewelry Trends to Watch</h3>
                        <p class="blog-excerpt">Discover the latest jewelry trends and styles that will dominate the fashion world this year.</p>
                        <div class="blog-meta">
                            <span>Coming Soon</span>
                            <a href="#" class="read-more">Read More</a>
                        </div>
                    </div>
                </div>
                
                <div class="blog-card">
                    <div class="blog-image">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div class="blog-content-card">
                        <div class="blog-category">Gift Guide</div>
                        <h3 class="blog-title">Jewelry Gift Ideas for Every Occasion</h3>
                        <p class="blog-excerpt">Find the perfect jewelry gift for birthdays, anniversaries, holidays, and special celebrations.</p>
                        <div class="blog-meta">
                            <span>Coming Soon</span>
                            <a href="#" class="read-more">Read More</a>
                        </div>
                    </div>
                </div>
                
                <div class="blog-card">
                    <div class="blog-image">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="blog-content-card">
                        <div class="blog-category">Investment</div>
                        <h3 class="blog-title">Jewelry as an Investment</h3>
                        <p class="blog-excerpt">Learn how to make smart jewelry investments and understand which pieces hold their value over time.</p>
                        <div class="blog-meta">
                            <span>Coming Soon</span>
                            <a href="#" class="read-more">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter Signup -->
        <div class="newsletter-signup">
            <h3>Stay Updated with Jewelry Tips & Trends</h3>
            <p>Subscribe to our newsletter and be the first to know about new articles, exclusive offers, and jewelry care tips.</p>
            <form class="newsletter-form">
                <input type="email" class="newsletter-input" placeholder="Enter your email address" required>
                <button type="submit" class="newsletter-btn">Subscribe</button>
            </form>
        </div>
    </div>
</div>

<!-- Structured Data for Blog -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Jewelry Blog - SK Ornaments",
    "description": "Jewelry blog featuring care tips, trends, and expert advice from SK Ornaments.",
    "url": "{{ url('/blog') }}",
    "publisher": {
        "@type": "Organization",
        "name": "SK Ornaments",
        "url": "{{ url('/') }}"
    },
    "dateModified": "2025-02-15",
    "mainEntity": {
        "@type": "Blog",
        "name": "SK Ornaments Jewelry Blog",
        "description": "Expert jewelry care tips, trends, and advice from SK Ornaments.",
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