@extends('layout.header')

@section('title', 'Terms & Conditions - SK Ornaments | Legal Terms & User Agreement')
@section('description', 'Read SK Ornaments Terms & Conditions to understand your rights and obligations when using our website and services. Learn about ordering, returns, and legal terms.')
@section('keywords', 'terms and conditions, user agreement, legal terms, SK Ornaments terms, jewelry store terms')

@section('og_title', 'Terms & Conditions - SK Ornaments')
@section('og_description', 'Read the terms and conditions for using SK Ornaments website and services. Understand your rights and obligations.')

<style>
    .terms-page {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .terms-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 0;
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .terms-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .terms-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .terms-content {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .terms-section {
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
    
    .terms-text {
        font-size: 1rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 1.5rem;
    }
    
    .terms-list {
        margin: 1.5rem 0;
        padding-left: 2rem;
    }
    
    .terms-list li {
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
        .terms-hero h1 {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .terms-section {
            padding: 2rem;
        }
    }
</style>

<!-- Terms & Conditions Page -->
<div class="terms-page">
    <!-- Hero Section -->
    <div class="terms-hero">
        <div class="container">
            <h1>Terms & Conditions</h1>
            <p>Please read these terms and conditions carefully before using our website and services.</p>
        </div>
    </div>

    <div class="container terms-content">
        <!-- Introduction -->
        <div class="terms-section">
            <h2 class="section-title">Introduction</h2>
            <p class="terms-text">
                These Terms and Conditions ("Terms") govern your use of the SK Ornaments website and services. By accessing or using our website, you agree to be bound by these Terms. If you disagree with any part of these terms, please do not use our services.
            </p>
            <p class="terms-text">
                These Terms apply to all visitors, users, and others who access or use our website. By using our website, you represent that you are at least 18 years old and have the legal capacity to enter into these Terms.
            </p>
        </div>

        <!-- Acceptance of Terms -->
        <div class="terms-section">
            <h2 class="section-title">Acceptance of Terms</h2>
            <p class="terms-text">
                By accessing and using the SK Ornaments website, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.
            </p>
        </div>

        <!-- Use License -->
        <div class="terms-section">
            <h2 class="section-title">Use License</h2>
            <p class="terms-text">
                Permission is granted to temporarily download one copy of the materials (information or software) on SK Ornaments's website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
            </p>
            <ul class="terms-list">
                <li>Modify or copy the materials</li>
                <li>Use the materials for any commercial purpose or for any public display (commercial or non-commercial)</li>
                <li>Attempt to decompile or reverse engineer any software contained on SK Ornaments's website</li>
                <li>Remove any copyright or other proprietary notations from the materials</li>
                <li>Transfer the materials to another person or "mirror" the materials on any other server</li>
            </ul>
        </div>

        <!-- User Account -->
        <div class="terms-section">
            <h2 class="section-title">User Account</h2>
            <p class="terms-text">
                When you create an account with us, you must provide information that is accurate, complete, and current at all times. You are responsible for safeguarding the password and for all activities that occur under your account.
            </p>
            <p class="terms-text">
                You agree not to disclose your password to any third party and to take sole responsibility for any activities or actions under your account, whether or not you have authorized such activities or actions.
            </p>
        </div>

        <!-- Product Information -->
        <div class="terms-section">
            <h2 class="section-title">Product Information</h2>
            <p class="terms-text">
                We strive to display accurate product information, including prices, descriptions, and images. However, we do not warrant that product descriptions, colors, information, or other content available on the website is accurate, complete, reliable, current, or error-free.
            </p>
            
            <h3 class="subsection-title">Product Images</h3>
            <p class="terms-text">
                Product images are for illustrative purposes only. Actual products may vary slightly in appearance due to lighting, display settings, and individual monitor variations.
            </p>
            
            <h3 class="subsection-title">Pricing</h3>
            <p class="terms-text">
                All prices are subject to change without notice. We reserve the right to modify or discontinue any product at any time. Prices do not include applicable taxes, shipping, or handling charges.
            </p>
        </div>

        <!-- Ordering and Payment -->
        <div class="terms-section">
            <h2 class="section-title">Ordering and Payment</h2>
            
            <h3 class="subsection-title">Order Acceptance</h3>
            <p class="terms-text">
                All orders are subject to acceptance and availability. We reserve the right to refuse any order for any reason, including but not limited to:
            </p>
            <ul class="terms-list">
                <li>Product unavailability</li>
                <li>Pricing errors</li>
                <li>Payment issues</li>
                <li>Suspicious or fraudulent activity</li>
            </ul>
            
            <h3 class="subsection-title">Payment Methods</h3>
            <p class="terms-text">
                We accept various payment methods including credit cards, debit cards, UPI, and net banking. All payments are processed securely through our trusted payment partners.
            </p>
            
            <h3 class="subsection-title">Order Confirmation</h3>
            <p class="terms-text">
                You will receive an order confirmation email once your order is successfully placed. Please review the confirmation carefully and contact us immediately if you notice any errors.
            </p>
        </div>

        <!-- Shipping and Delivery -->
        <div class="terms-section">
            <h2 class="section-title">Shipping and Delivery</h2>
            <p class="terms-text">
                We offer free shipping on all orders. Delivery times may vary depending on your location and product availability. Estimated delivery times are provided at checkout but are not guaranteed.
            </p>
            
            <h3 class="subsection-title">Delivery Address</h3>
            <p class="terms-text">
                Please ensure your delivery address is accurate and complete. We are not responsible for delays or failed deliveries due to incorrect address information.
            </p>
            
            <h3 class="subsection-title">Delivery Confirmation</h3>
            <p class="terms-text">
                Upon delivery, please inspect your order for any damage or defects. Report any issues within 24 hours of delivery.
            </p>
        </div>

        <!-- Returns and Refunds -->
        <div class="terms-section">
            <h2 class="section-title">Returns and Refunds</h2>
            
            <h3 class="subsection-title">Return Policy</h3>
            <p class="terms-text">
                We offer a 30-day return policy for most items. Items must be returned in their original condition with all original packaging and tags intact.
            </p>
            
            <h3 class="subsection-title">Non-Returnable Items</h3>
            <p class="terms-text">
                The following items are non-returnable:
            </p>
            <ul class="terms-list">
                <li>Custom or personalized jewelry</li>
                <li>Sale or clearance items (unless defective)</li>
                <li>Items marked as "Final Sale"</li>
                <li>Damaged or altered items</li>
            </ul>
            
            <h3 class="subsection-title">Refund Process</h3>
            <p class="terms-text">
                Refunds will be processed within 5-7 business days after we receive your returned item. Refunds will be issued to the original payment method used for the purchase.
            </p>
        </div>

        <!-- Intellectual Property -->
        <div class="terms-section">
            <h2 class="section-title">Intellectual Property</h2>
            <p class="terms-text">
                The website and its original content, features, and functionality are and will remain the exclusive property of SK Ornaments and its licensors. The website is protected by copyright, trademark, and other laws.
            </p>
            <p class="terms-text">
                Our trademarks and trade dress may not be used in connection with any product or service without our prior written consent.
            </p>
        </div>

        <!-- Privacy Policy -->
        <div class="terms-section">
            <h2 class="section-title">Privacy Policy</h2>
            <p class="terms-text">
                Your privacy is important to us. Please review our Privacy Policy, which also governs your use of the website, to understand our practices.
            </p>
        </div>

        <!-- Limitation of Liability -->
        <div class="terms-section">
            <h2 class="section-title">Limitation of Liability</h2>
            <p class="terms-text">
                In no event shall SK Ornaments, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential, or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from your use of the website.
            </p>
            
            <div class="highlight-box">
                <h4>Important Notice:</h4>
                <p>Our total liability to you for any claims arising from your use of our website or services shall not exceed the amount you paid to us in the 12 months preceding the claim.</p>
            </div>
        </div>

        <!-- Disclaimers -->
        <div class="terms-section">
            <h2 class="section-title">Disclaimers</h2>
            <p class="terms-text">
                The information on this website is provided on an "as is" basis. SK Ornaments makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.
            </p>
        </div>

        <!-- Governing Law -->
        <div class="terms-section">
            <h2 class="section-title">Governing Law</h2>
            <p class="terms-text">
                These Terms shall be interpreted and governed by the laws of India, without regard to its conflict of law provisions. Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights.
            </p>
        </div>

        <!-- Changes to Terms -->
        <div class="terms-section">
            <h2 class="section-title">Changes to Terms</h2>
            <p class="terms-text">
                We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material, we will try to provide at least 30 days notice prior to any new terms taking effect.
            </p>
            <p class="terms-text">
                What constitutes a material change will be determined at our sole discretion. By continuing to access or use our website after those revisions become effective, you agree to be bound by the revised terms.
            </p>
        </div>

        <!-- Contact Information -->
        <div class="contact-info">
            <h3>Contact Us</h3>
            <p>If you have any questions about these Terms & Conditions, please contact us:</p>
            <p><strong>Email:</strong> <a href="mailto:legal@skornaments.com">legal@skornaments.com</a></p>
            <p><strong>Phone:</strong> <a href="tel:8450999000">+91 8450999000</a></p>
            <p><strong>Address:</strong> 201, Bansari Bhuvan, Shop No.11, Tamil Sangam Marg, Opp. Union Bank, Sion (E), Mumbai - 400 022, India</p>
        </div>

        <!-- Last Updated -->
        <div class="last-updated">
            <p><strong>Last Updated:</strong> February 15, 2025</p>
        </div>
    </div>
</div>

<!-- Structured Data for Terms & Conditions -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Terms & Conditions - SK Ornaments",
    "description": "Terms and Conditions for SK Ornaments jewelry store. Read our legal terms and user agreement.",
    "url": "{{ url('/terms-conditions') }}",
    "publisher": {
        "@type": "Organization",
        "name": "SK Ornaments",
        "url": "{{ url('/') }}"
    },
    "dateModified": "2025-02-15",
    "mainEntity": {
        "@type": "Article",
        "name": "Terms & Conditions",
        "description": "Comprehensive terms and conditions for using SK Ornaments website and services.",
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