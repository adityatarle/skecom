@extends('layout.header')

@section('title', 'Return Policy - 30-Day Returns & Refunds | SK Ornaments')
@section('description', 'Learn about SK Ornaments return policy, 30-day return window, and refund process. Get information about return conditions and procedures.')
@section('keywords', 'return policy, refund policy, jewelry returns, 30-day returns, SK Ornaments returns')

@section('og_title', 'Return Policy - SK Ornaments')
@section('og_description', 'Learn about our 30-day return policy and refund process for all jewelry orders.')

<style>
    .return-page {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .return-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 0;
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .return-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .return-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .return-content {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .return-section {
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
    
    .return-text {
        font-size: 1rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 1.5rem;
    }
    
    .return-list {
        margin: 1.5rem 0;
        padding-left: 2rem;
    }
    
    .return-list li {
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
    
    .return-table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5rem 0;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .return-table th,
    .return-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
    }
    
    .return-table th {
        background: #667eea;
        color: white;
        font-weight: 600;
    }
    
    .return-table tr:hover {
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
        .return-hero h1 {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .return-section {
            padding: 2rem;
        }
        
        .return-table {
            font-size: 0.9rem;
        }
        
        .return-table th,
        .return-table td {
            padding: 0.75rem;
        }
    }
</style>

<!-- Return Policy Page -->
<div class="return-page">
    <!-- Hero Section -->
    <div class="return-hero">
        <div class="container">
            <h1>Return Policy</h1>
            <p>We want you to be completely satisfied with your purchase. Learn about our 30-day return policy and easy refund process.</p>
        </div>
    </div>

    <div class="container return-content">
        <!-- Return Policy Overview -->
        <div class="return-section">
            <h2 class="section-title">30-Day Return Policy</h2>
            <p class="return-text">
                At SK Ornaments, we stand behind the quality of our jewelry. We offer a <strong>30-day return policy</strong> on most items, giving you peace of mind with your purchase.
            </p>
            
            <div class="highlight-box">
                <h4>✅ Easy Returns</h4>
                <ul class="return-list">
                    <li>30-day return window from delivery date</li>
                    <li>Free return shipping on eligible items</li>
                    <li>Full refund or exchange options</li>
                    <li>Simple online return process</li>
                    <li>Dedicated customer support for returns</li>
                </ul>
            </div>
        </div>

        <!-- Return Conditions -->
        <div class="return-section">
            <h2 class="section-title">Return Conditions</h2>
            
            <h3 class="subsection-title">Items Eligible for Return</h3>
            <p class="return-text">
                Most items can be returned within 30 days of delivery, provided they meet the following conditions:
            </p>
            
            <ul class="return-list">
                <li>Item is in original, unworn condition</li>
                <li>All original packaging and tags are intact</li>
                <li>No signs of wear, damage, or alteration</li>
                <li>Original receipt or order confirmation</li>
                <li>Return request submitted within 30 days</li>
            </ul>
            
            <h3 class="subsection-title">Non-Returnable Items</h3>
            <p class="return-text">
                The following items cannot be returned:
            </p>
            
            <ul class="return-list">
                <li>Custom or personalized jewelry</li>
                <li>Sale or clearance items (unless defective)</li>
                <li>Items marked as "Final Sale"</li>
                <li>Damaged or altered items</li>
                <li>Items without original packaging</li>
                <li>Gift cards and vouchers</li>
            </ul>
            
            <div class="warning-box">
                <h4>⚠️ Important Note</h4>
                <p>Custom jewelry, engraved items, and personalized pieces cannot be returned unless there is a manufacturing defect. Please ensure all custom specifications are correct before placing your order.</p>
            </div>
        </div>

        <!-- Return Process -->
        <div class="return-section">
            <h2 class="section-title">How to Return an Item</h2>
            
            <h3 class="subsection-title">Step-by-Step Return Process</h3>
            <ol class="return-list">
                <li><strong>Contact Us:</strong> Email or call us within 30 days of delivery</li>
                <li><strong>Provide Details:</strong> Include order number and reason for return</li>
                <li><strong>Get Approval:</strong> We'll review and approve your return request</li>
                <li><strong>Package Item:</strong> Securely package the item with all original materials</li>
                <li><strong>Ship Back:</strong> Use our prepaid return label or your preferred method</li>
                <li><strong>Receive Refund:</strong> Refund processed within 5-7 business days</li>
            </ol>
            
            <h3 class="subsection-title">Return Shipping</h3>
            <p class="return-text">
                We provide free return shipping for eligible items. For non-eligible returns, customers are responsible for return shipping costs.
            </p>
            
            <table class="return-table">
                <thead>
                    <tr>
                        <th>Return Type</th>
                        <th>Shipping Cost</th>
                        <th>Processing Time</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Eligible Returns</td>
                        <td>FREE</td>
                        <td>5-7 days</td>
                        <td>Prepaid label provided</td>
                    </tr>
                    <tr>
                        <td>Non-Eligible Returns</td>
                        <td>Customer pays</td>
                        <td>5-7 days</td>
                        <td>Customer arranges shipping</td>
                    </tr>
                    <tr>
                        <td>Defective Items</td>
                        <td>FREE</td>
                        <td>3-5 days</td>
                        <td>Priority processing</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Refund Process -->
        <div class="return-section">
            <h2 class="section-title">Refund Process</h2>
            
            <h3 class="subsection-title">Refund Timeline</h3>
            <p class="return-text">
                Once we receive your returned item, we'll inspect it and process your refund according to the following timeline:
            </p>
            
            <ul class="return-list">
                <li><strong>Inspection Period:</strong> 1-2 business days</li>
                <li><strong>Refund Processing:</strong> 3-5 business days</li>
                <li><strong>Bank Processing:</strong> 2-7 business days (varies by bank)</li>
                <li><strong>Total Timeline:</strong> 5-14 business days</li>
            </ul>
            
            <h3 class="subsection-title">Refund Methods</h3>
            <p class="return-text">
                Refunds are processed to the original payment method used for the purchase:
            </p>
            
            <ul class="return-list">
                <li><strong>Credit/Debit Cards:</strong> Refunded to original card</li>
                <li><strong>UPI Payments:</strong> Refunded to UPI ID</li>
                <li><strong>Net Banking:</strong> Refunded to bank account</li>
                <li><strong>Digital Wallets:</strong> Refunded to wallet account</li>
            </ul>
            
            <div class="highlight-box">
                <h4>💳 Refund Information</h4>
                <p>Refunds are processed to the original payment method. If you paid with a credit card, the refund will appear on your next billing statement. For other payment methods, the refund will be credited to your account within the specified timeline.</p>
            </div>
        </div>

        <!-- Exchange Policy -->
        <div class="return-section">
            <h2 class="section-title">Exchange Policy</h2>
            
            <h3 class="subsection-title">Size Exchanges</h3>
            <p class="return-text">
                We offer free size exchanges for rings and bracelets within 30 days of delivery:
            </p>
            
            <ul class="return-list">
                <li>Free size exchange for rings (up to 2 sizes)</li>
                <li>Free size exchange for bracelets</li>
                <li>Exchanges subject to availability</li>
                <li>Processing time: 3-5 business days</li>
            </ul>
            
            <h3 class="subsection-title">Style Exchanges</h3>
            <p class="return-text">
                You can exchange your item for a different style within 30 days:
            </p>
            
            <ul class="return-list">
                <li>Exchange for items of equal or greater value</li>
                <li>Pay difference for upgrades</li>
                <li>Refund difference for downgrades</li>
                <li>Subject to item availability</li>
            </ul>
        </div>

        <!-- Defective Items -->
        <div class="return-section">
            <h2 class="section-title">Defective Items</h2>
            
            <h3 class="subsection-title">Manufacturing Defects</h3>
            <p class="return-text">
                If you receive a defective item, we'll replace it or provide a full refund:
            </p>
            
            <ul class="return-list">
                <li>Free replacement for defective items</li>
                <li>Full refund option available</li>
                <li>Priority processing for defects</li>
                <li>Free return shipping</li>
                <li>Extended warranty on replacements</li>
            </ul>
            
            <h3 class="subsection-title">What Constitutes a Defect</h3>
            <p class="return-text">
                Manufacturing defects include:
            </p>
            
            <ul class="return-list">
                <li>Loose or missing stones</li>
                <li>Broken clasps or chains</li>
                <li>Discoloration or tarnishing</li>
                <li>Structural damage</li>
                <li>Quality issues not caused by wear</li>
            </ul>
        </div>

        <!-- Return Restrictions -->
        <div class="return-section">
            <h2 class="section-title">Return Restrictions</h2>
            
            <div class="warning-box">
                <h4>🚫 Items That Cannot Be Returned</h4>
                <ul class="return-list">
                    <li>Custom or personalized jewelry</li>
                    <li>Engraved items</li>
                    <li>Sale or clearance items</li>
                    <li>Items marked as "Final Sale"</li>
                    <li>Damaged or altered items</li>
                    <li>Items without original packaging</li>
                    <li>Gift cards and vouchers</li>
                    <li>Items purchased from third-party sellers</li>
                </ul>
            </div>
            
            <h3 class="subsection-title">Restocking Fee</h3>
            <p class="return-text">
                A 10% restocking fee may apply to returns of high-value items (over ₹50,000) that are returned without a valid reason or in non-original condition.
            </p>
        </div>

        <!-- Contact Information -->
        <div class="contact-info">
            <h3>Need Help with Returns?</h3>
            <p>Our customer service team is here to help with any return questions or issues.</p>
            <p><strong>Email:</strong> <a href="mailto:returns@skornaments.com">returns@skornaments.com</a></p>
            <p><strong>Phone:</strong> <a href="tel:8450999000">+91 8450999000</a></p>
            <p><strong>WhatsApp:</strong> <a href="https://wa.me/918450999000">+91 8450999000</a></p>
            <p><strong>Business Hours:</strong> Monday - Saturday, 10:00 AM - 8:00 PM IST</p>
        </div>

        <!-- Last Updated -->
        <div class="last-updated">
            <p><strong>Last Updated:</strong> February 15, 2025</p>
        </div>
    </div>
</div>

<!-- Structured Data for Return Policy -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Return Policy - SK Ornaments",
    "description": "Return policy for SK Ornaments jewelry store. Learn about 30-day returns and refund process.",
    "url": "{{ url('/return-policy') }}",
    "publisher": {
        "@type": "Organization",
        "name": "SK Ornaments",
        "url": "{{ url('/') }}"
    },
    "dateModified": "2025-02-15",
    "mainEntity": {
        "@type": "Article",
        "name": "Return Policy",
        "description": "Comprehensive return policy including 30-day returns, refund process, and exchange options.",
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