@extends('layout.header')

@section('title', 'Page Not Found - 404 Error | SK Ornaments')
@section('description', 'The page you are looking for could not be found. Browse our jewelry collection or return to the homepage.')
@section('robots', 'noindex, nofollow')

<style>
    .error-page {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    
    .error-container {
        text-align: center;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .error-code {
        font-size: 8rem;
        font-weight: 900;
        color: #667eea;
        margin-bottom: 1rem;
        text-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        line-height: 1;
    }
    
    .error-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1rem;
    }
    
    .error-message {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    
    .error-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 3rem;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .btn-primary:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    
    .btn-secondary {
        background: white;
        color: #667eea;
        padding: 1rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        border: 2px solid #667eea;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: #667eea;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }
    
    .search-section {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-top: 2rem;
    }
    
    .search-section h3 {
        color: #333;
        margin-bottom: 1rem;
    }
    
    .search-form {
        display: flex;
        gap: 1rem;
        max-width: 400px;
        margin: 0 auto;
    }
    
    .search-input {
        flex: 1;
        padding: 0.75rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        outline: none;
        transition: border-color 0.3s ease;
    }
    
    .search-input:focus {
        border-color: #667eea;
    }
    
    .search-btn {
        background: #667eea;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    
    .search-btn:hover {
        background: #5a6fd8;
    }
    
    .popular-links {
        margin-top: 2rem;
    }
    
    .popular-links h4 {
        color: #333;
        margin-bottom: 1rem;
    }
    
    .links-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .link-item {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .link-item:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }
    
    .link-item a {
        color: inherit;
        text-decoration: none;
        font-weight: 500;
    }
    
    @media (max-width: 768px) {
        .error-code {
            font-size: 6rem;
        }
        
        .error-title {
            font-size: 2rem;
        }
        
        .error-actions {
            flex-direction: column;
            align-items: center;
        }
        
        .search-form {
            flex-direction: column;
        }
    }
</style>

<!-- 404 Error Page -->
<div class="error-page">
    <div class="container">
        <div class="error-container">
            <div class="error-code">404</div>
            <h1 class="error-title">Page Not Found</h1>
            <p class="error-message">
                Oops! The page you are looking for doesn't exist. It might have been moved, deleted, or you entered the wrong URL.
            </p>
            
            <div class="error-actions">
                <a href="{{ route('home') }}" class="btn-primary">
                    <i class="fas fa-home me-2"></i>Go to Homepage
                </a>
                <a href="{{ route('products') }}" class="btn-secondary">
                    <i class="fas fa-shopping-bag me-2"></i>Browse Products
                </a>
            </div>
            
            <div class="search-section">
                <h3>Looking for something specific?</h3>
                <form action="{{ route('products') }}" method="GET" class="search-form">
                    <input type="text" name="search" class="search-input" placeholder="Search for jewelry..." required>
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <div class="popular-links">
                <h4>Popular Pages</h4>
                <div class="links-grid">
                    <div class="link-item">
                        <a href="{{ route('about') }}">
                            <i class="fas fa-info-circle me-2"></i>About Us
                        </a>
                    </div>
                    <div class="link-item">
                        <a href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-2"></i>Contact
                        </a>
                    </div>
                    <div class="link-item">
                        <a href="{{ route('size.guide') }}">
                            <i class="fas fa-ruler me-2"></i>Size Guide
                        </a>
                    </div>
                    <div class="link-item">
                        <a href="{{ route('jewelry.care') }}">
                            <i class="fas fa-gem me-2"></i>Jewelry Care
                        </a>
                    </div>
                    <div class="link-item">
                        <a href="{{ route('blog') }}">
                            <i class="fas fa-blog me-2"></i>Blog
                        </a>
                    </div>
                    <div class="link-item">
                        <a href="{{ route('privacy.policy') }}">
                            <i class="fas fa-shield-alt me-2"></i>Privacy Policy
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')