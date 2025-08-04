@extends('layout.header')

@section('title', 'Shipping Policy - Free Shipping & Delivery Information | SK Ornaments')
@section('description', 'Learn about SK Ornaments shipping policy, delivery times, and free shipping offers. Get information about domestic and international shipping options.')
@section('keywords', 'shipping policy, free shipping, delivery, jewelry shipping, SK Ornaments shipping')

@section('og_title', 'Shipping Policy - SK Ornaments')
@section('og_description', 'Learn about our shipping policy, delivery times, and free shipping offers for all jewelry orders.')

<style>
    .shipping-page {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .shipping-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 0;
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .shipping-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .shipping-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .shipping-content {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .shipping-section {
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
    
    .shipping-text {
        font-size: 1rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 1.5rem;
    }
    
    .shipping-list {
        margin: 1.5rem 0;
        padding-left: 2rem;
    }
    
    .shipping-list li {
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
    
    .shipping-table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5rem 0;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .shipping-table th,
    .shipping-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
    }
    
    .shipping-table th {
        background: #667eea;
        color: white;
        font-weight: 600;
    }
    
    .shipping-table tr:hover {
        background: #f8f9fa;
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
    
    .last-updated {
        background: #e9ecef;
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        margin-top: 2rem;
        font-weight: 500;
        color: #666;
    }
    
    @media (max-width: 768px) {
        .shipping-hero h1 {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .shipping-section {
            padding: 2rem;
        }
        
        .shipping-table {
            font-size: 0.9rem;
        }
        
        .shipping-table th,
        .shipping-table td {
            padding: 0.75rem;
        }
    }
</style>

<!-- Shipping Policy Page -->
<div class="shipping-page">
    <!-- Hero Section -->
    <div class="shipping-hero">
        <div class="container">
            <h1>Shipping Policy</h1>
            <p>Learn about our shipping options, delivery times, and free shipping offers for all your jewelry needs.</p>
        </div>
    </div>

    <div class="container shipping-content">
        <!-- Free Shipping -->
        <div class="shipping-section">
            <h2 class="section-title">Free Shipping</h2>
            <p class="shipping-text">
                We offer <strong>FREE SHIPPING</strong> on all orders, regardless of order value. No minimum purchase required!
            </p>
            
            <div class="highlight-box">
                <h4>🎉 Free Shipping Benefits</h4>
                <ul class="shipping-list">
                    <li>No minimum order value required</li>
                    <li>Free shipping on all jewelry items</li>
                    <li>Secure packaging and insurance included</li>
                    <li>Tracking number provided for all orders</li>
                    <li>Signature confirmation for high-value items</li>
                </ul>
            </div>
        </div>

        <!-- Shipping Methods -->
        <div class="shipping-section">
            <h2 class="section-title">Shipping Methods</h2>
            
            <h3 class="subsection-title">Standard Shipping</h3>
            <p class="shipping-text">
                Our standard shipping is handled by trusted courier partners and includes full tracking and insurance.
            </p>
            
            <table class="shipping-table">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Delivery Time</th>
                        <th>Features</th>
                        <th>Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Standard Delivery</td>
                        <td>3-5 Business Days</td>
                        <td>Tracking, Insurance</td>
                        <td>FREE</td>
                    </tr>
                    <tr>
                        <td>Express Delivery</td>
                        <td>1-2 Business Days</td>
                        <td>Priority Tracking, Insurance</td>
                        <td>₹200</td>
                    </tr>
                    <tr>
                        <td>Same Day Delivery</td>
                        <td>Same Day (Mumbai)</td>
                        <td>Premium Service, Insurance</td>
                        <td>₹500</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Delivery Areas -->
        <div class="shipping-section">
            <h2 class="section-title">Delivery Areas</h2>
            
            <h3 class="subsection-title">Domestic Shipping</h3>
            <p class="shipping-text">
                We ship to all major cities and towns across India through our network of reliable courier partners.
            </p>
            
            <ul class="shipping-list">
                <li><strong>Metro Cities:</strong> Mumbai, Delhi, Bangalore, Chennai, Kolkata, Hyderabad, Pune, Ahmedabad</li>
                <li><strong>State Capitals:</strong> All state capitals and major cities</li>
                <li><strong>Rural Areas:</strong> Most rural areas with courier service</li>
                <li><strong>Remote Locations:</strong> Subject to courier availability</li>
            </ul>
            
            <h3 class="subsection-title">International Shipping</h3>
            <p class="shipping-text">
                Currently, we offer international shipping to select countries. Please contact us for international shipping rates and delivery times.
            </p>
        </div>

        <!-- Order Processing -->
        <div class="shipping-section">
            <h2 class="section-title">Order Processing</h2>
            
            <h3 class="subsection-title">Processing Time</h3>
            <p class="shipping-text">
                Orders are typically processed and shipped within 1-2 business days of payment confirmation.
            </p>
            
            <ul class="shipping-list">
                <li><strong>In-Stock Items:</strong> Shipped within 1 business day</li>
                <li><strong>Custom Orders:</strong> 3-5 business days processing</li>
                <li><strong>Engagement Rings:</strong> 2-3 business days processing</li>
                <li><strong>Bulk Orders:</strong> 3-7 business days processing</li>
            </ul>
            
            <h3 class="subsection-title">Order Status Updates</h3>
            <p class="shipping-text">
                You will receive email updates at each stage of your order:
            </p>
            
            <ul class="shipping-list">
                <li>Order confirmation email</li>
                <li>Processing status update</li>
                <li>Shipping confirmation with tracking number</li>
                <li>Delivery confirmation</li>
            </ul>
        </div>

        <!-- Packaging & Insurance -->
        <div class="shipping-section">
            <h2 class="section-title">Packaging & Insurance</h2>
            
            <h3 class="subsection-title">Secure Packaging</h3>
            <p class="shipping-text">
                All jewelry items are carefully packaged to ensure safe delivery:
            </p>
            
            <ul class="shipping-list">
                <li>Jewelry boxes with protective padding</li>
                <li>Bubble wrap and protective materials</li>
                <li>Tamper-evident packaging</li>
                <li>Discrete packaging for security</li>
                <li>Weather-resistant outer packaging</li>
            </ul>
            
            <h3 class="subsection-title">Insurance Coverage</h3>
            <p class="shipping-text">
                All shipments include insurance coverage:
            </p>
            
            <ul class="shipping-list">
                <li>Full value insurance on all orders</li>
                <li>Coverage against loss, damage, and theft</li>
                <li>Quick claim processing</li>
                <li>Replacement or refund options</li>
            </ul>
        </div>

        <!-- Delivery & Tracking -->
        <div class="shipping-section">
            <h2 class="section-title">Delivery & Tracking</h2>
            
            <h3 class="subsection-title">Tracking Your Order</h3>
            <p class="shipping-text">
                Track your order in real-time through multiple channels:
            </p>
            
            <ul class="shipping-list">
                <li>Order tracking through your account</li>
                <li>Email updates with tracking links</li>
                <li>SMS notifications for delivery updates</li>
                <li>Courier partner tracking websites</li>
            </ul>
            
            <h3 class="subsection-title">Delivery Options</h3>
            <p class="shipping-text">
                We offer flexible delivery options to suit your needs:
            </p>
            
            <ul class="shipping-list">
                <li><strong>Home Delivery:</strong> Standard delivery to your address</li>
                <li><strong>Office Delivery:</strong> Delivery to your workplace</li>
                <li><strong>Pickup Points:</strong> Collect from nearby pickup locations</li>
                <li><strong>Signature Required:</strong> For high-value items</li>
            </ul>
        </div>

        <!-- Delivery Issues -->
        <div class="shipping-section">
            <h2 class="section-title">Delivery Issues & Solutions</h2>
            
            <h3 class="subsection-title">Common Issues</h3>
            <p class="shipping-text">
                If you experience any delivery issues, we're here to help:
            </p>
            
            <ul class="shipping-list">
                <li><strong>Package Not Delivered:</strong> Contact us within 24 hours</li>
                <li><strong>Damaged Package:</strong> Document and report immediately</li>
                <li><strong>Wrong Address:</strong> Update address in your account</li>
                <li><strong>Delivery Attempt Failed:</strong> Reschedule delivery</li>
            </ul>
            
            <h3 class="subsection-title">Customer Support</h3>
            <p class="shipping-text">
                Our customer support team is available to help with any shipping-related issues:
            </p>
            
            <ul class="shipping-list">
                <li>24/7 email support</li>
                <li>Phone support during business hours</li>
                <li>Live chat assistance</li>
                <li>WhatsApp support</li>
            </ul>
        </div>

        <!-- Contact Information -->
        <div class="contact-info">
            <h3>Need Help with Shipping?</h3>
            <p>Our customer service team is here to help with any shipping questions or issues.</p>
            <p><strong>Email:</strong> <a href="mailto:shipping@skornaments.com">shipping@skornaments.com</a></p>
            <p><strong>Phone:</strong> <a href="tel:8450999000">+91 8450999000</a></p>
            <p><strong>WhatsApp:</strong> <a href="https://wa.me/918450999000">+91 8450999000</a></p>
        </div>

        <!-- Last Updated -->
        <div class="last-updated">
            <p><strong>Last Updated:</strong> February 15, 2025</p>
        </div>
    </div>
</div>

<!-- Structured Data for Shipping Policy -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Shipping Policy - SK Ornaments",
    "description": "Shipping policy for SK Ornaments jewelry store. Learn about free shipping, delivery times, and shipping options.",
    "url": "{{ url('/shipping-policy') }}",
    "publisher": {
        "@type": "Organization",
        "name": "SK Ornaments",
        "url": "{{ url('/') }}"
    },
    "dateModified": "2025-02-15",
    "mainEntity": {
        "@type": "Article",
        "name": "Shipping Policy",
        "description": "Comprehensive shipping policy including free shipping, delivery times, and shipping options.",
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