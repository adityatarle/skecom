@extends('layout.header')

@section('title', 'Privacy Policy - SK Ornaments | Data Protection & Privacy Information')
@section('description', 'Read SK Ornaments Privacy Policy to understand how we collect, use, and protect your personal information. Learn about data security, cookies, and your privacy rights.')
@section('keywords', 'privacy policy, data protection, personal information, cookies, SK Ornaments privacy, jewelry store privacy')

@section('og_title', 'Privacy Policy - SK Ornaments')
@section('og_description', 'Learn how SK Ornaments protects your privacy and personal information. Read our comprehensive privacy policy.')

<style>
    .privacy-page {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .privacy-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 0;
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .privacy-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .privacy-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .privacy-content {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .privacy-section {
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
    
    .privacy-text {
        font-size: 1rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 1.5rem;
    }
    
    .privacy-list {
        margin: 1.5rem 0;
        padding-left: 2rem;
    }
    
    .privacy-list li {
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
        .privacy-hero h1 {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .privacy-section {
            padding: 2rem;
        }
    }
</style>

<!-- Privacy Policy Page -->
<div class="privacy-page">
    <!-- Hero Section -->
    <div class="privacy-hero">
        <div class="container">
            <h1>Privacy Policy</h1>
            <p>Your privacy is important to us. This policy explains how we collect, use, and protect your personal information.</p>
        </div>
    </div>

    <div class="container privacy-content">
        <!-- Introduction -->
        <div class="privacy-section">
            <h2 class="section-title">Introduction</h2>
            <p class="privacy-text">
                At SK Ornaments, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website, make purchases, or interact with our services.
            </p>
            <p class="privacy-text">
                By using our website and services, you consent to the collection and use of information in accordance with this policy. We may update this Privacy Policy from time to time, and we will notify you of any changes by posting the new Privacy Policy on this page.
            </p>
        </div>

        <!-- Information We Collect -->
        <div class="privacy-section">
            <h2 class="section-title">Information We Collect</h2>
            
            <h3 class="subsection-title">Personal Information</h3>
            <p class="privacy-text">We may collect the following personal information:</p>
            <ul class="privacy-list">
                <li>Name, email address, and phone number</li>
                <li>Billing and shipping addresses</li>
                <li>Payment information (processed securely through our payment partners)</li>
                <li>Order history and preferences</li>
                <li>Communication preferences</li>
            </ul>

            <h3 class="subsection-title">Automatically Collected Information</h3>
            <p class="privacy-text">When you visit our website, we automatically collect:</p>
            <ul class="privacy-list">
                <li>IP address and browser type</li>
                <li>Device information and operating system</li>
                <li>Pages visited and time spent on our website</li>
                <li>Referring website information</li>
                <li>Cookies and similar tracking technologies</li>
            </ul>
        </div>

        <!-- How We Use Your Information -->
        <div class="privacy-section">
            <h2 class="section-title">How We Use Your Information</h2>
            <p class="privacy-text">We use the collected information for the following purposes:</p>
            
            <ul class="privacy-list">
                <li><strong>Order Processing:</strong> To process and fulfill your orders, send order confirmations, and provide customer support</li>
                <li><strong>Communication:</strong> To respond to your inquiries, send important updates, and provide customer service</li>
                <li><strong>Marketing:</strong> To send promotional offers, newsletters, and product updates (with your consent)</li>
                <li><strong>Website Improvement:</strong> To analyze website usage, improve our services, and enhance user experience</li>
                <li><strong>Security:</strong> To protect against fraud, unauthorized access, and ensure website security</li>
                <li><strong>Legal Compliance:</strong> To comply with applicable laws, regulations, and legal processes</li>
            </ul>
        </div>

        <!-- Information Sharing -->
        <div class="privacy-section">
            <h2 class="section-title">Information Sharing and Disclosure</h2>
            <p class="privacy-text">We do not sell, trade, or rent your personal information to third parties. We may share your information in the following circumstances:</p>
            
            <ul class="privacy-list">
                <li><strong>Service Providers:</strong> With trusted third-party service providers who assist us in operating our website, processing payments, and delivering orders</li>
                <li><strong>Legal Requirements:</strong> When required by law, court order, or government regulation</li>
                <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets</li>
                <li><strong>Safety and Security:</strong> To protect our rights, property, or safety, or that of our customers or others</li>
            </ul>

            <div class="highlight-box">
                <h4>Important Note:</h4>
                <p>We ensure that all third-party service providers are bound by confidentiality agreements and use your information only for the specified purposes.</p>
            </div>
        </div>

        <!-- Cookies and Tracking -->
        <div class="privacy-section">
            <h2 class="section-title">Cookies and Tracking Technologies</h2>
            <p class="privacy-text">We use cookies and similar tracking technologies to enhance your browsing experience:</p>
            
            <h3 class="subsection-title">Types of Cookies We Use</h3>
            <ul class="privacy-list">
                <li><strong>Essential Cookies:</strong> Required for basic website functionality and security</li>
                <li><strong>Analytics Cookies:</strong> Help us understand how visitors use our website</li>
                <li><strong>Marketing Cookies:</strong> Used to deliver relevant advertisements and track marketing campaign performance</li>
                <li><strong>Preference Cookies:</strong> Remember your preferences and settings</li>
            </ul>

            <p class="privacy-text">You can control cookie settings through your browser preferences. However, disabling certain cookies may affect website functionality.</p>
        </div>

        <!-- Data Security -->
        <div class="privacy-section">
            <h2 class="section-title">Data Security</h2>
            <p class="privacy-text">We implement appropriate security measures to protect your personal information:</p>
            
            <ul class="privacy-list">
                <li>SSL encryption for secure data transmission</li>
                <li>Secure payment processing through trusted partners</li>
                <li>Regular security audits and updates</li>
                <li>Limited access to personal information on a need-to-know basis</li>
                <li>Secure data storage and backup procedures</li>
            </ul>

            <div class="highlight-box">
                <h4>Security Reminder:</h4>
                <p>While we strive to protect your information, no method of transmission over the internet is 100% secure. We cannot guarantee absolute security of your data.</p>
            </div>
        </div>

        <!-- Your Rights -->
        <div class="privacy-section">
            <h2 class="section-title">Your Privacy Rights</h2>
            <p class="privacy-text">You have the following rights regarding your personal information:</p>
            
            <ul class="privacy-list">
                <li><strong>Access:</strong> Request access to your personal information</li>
                <li><strong>Correction:</strong> Request correction of inaccurate or incomplete information</li>
                <li><strong>Deletion:</strong> Request deletion of your personal information (subject to legal requirements)</li>
                <li><strong>Portability:</strong> Request a copy of your data in a portable format</li>
                <li><strong>Opt-out:</strong> Unsubscribe from marketing communications</li>
                <li><strong>Complaint:</strong> Lodge a complaint with relevant data protection authorities</li>
            </ul>

            <p class="privacy-text">To exercise these rights, please contact us using the information provided below.</p>
        </div>

        <!-- Children's Privacy -->
        <div class="privacy-section">
            <h2 class="section-title">Children's Privacy</h2>
            <p class="privacy-text">
                Our website is not intended for children under the age of 13. We do not knowingly collect personal information from children under 13. If you are a parent or guardian and believe your child has provided us with personal information, please contact us immediately.
            </p>
        </div>

        <!-- International Transfers -->
        <div class="privacy-section">
            <h2 class="section-title">International Data Transfers</h2>
            <p class="privacy-text">
                Your information may be transferred to and processed in countries other than your own. We ensure that such transfers comply with applicable data protection laws and implement appropriate safeguards to protect your information.
            </p>
        </div>

        <!-- Changes to Privacy Policy -->
        <div class="privacy-section">
            <h2 class="section-title">Changes to This Privacy Policy</h2>
            <p class="privacy-text">
                We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last Updated" date. We encourage you to review this Privacy Policy periodically.
            </p>
        </div>

        <!-- Contact Information -->
        <div class="contact-info">
            <h3>Contact Us</h3>
            <p>If you have any questions about this Privacy Policy or our data practices, please contact us:</p>
            <p><strong>Email:</strong> <a href="mailto:privacy@skornaments.com">privacy@skornaments.com</a></p>
            <p><strong>Phone:</strong> <a href="tel:8450999000">+91 8450999000</a></p>
            <p><strong>Address:</strong> 201, Bansari Bhuvan, Shop No.11, Tamil Sangam Marg, Opp. Union Bank, Sion (E), Mumbai - 400 022, India</p>
        </div>

        <!-- Last Updated -->
        <div class="last-updated">
            <p><strong>Last Updated:</strong> February 15, 2025</p>
        </div>
    </div>
</div>

<!-- Structured Data for Privacy Policy -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Privacy Policy - SK Ornaments",
    "description": "Privacy Policy for SK Ornaments jewelry store. Learn how we protect your personal information and data.",
    "url": "{{ url('/privacy-policy') }}",
    "publisher": {
        "@type": "Organization",
        "name": "SK Ornaments",
        "url": "{{ url('/') }}"
    },
    "dateModified": "2025-02-15",
    "mainEntity": {
        "@type": "Article",
        "name": "Privacy Policy",
        "description": "Comprehensive privacy policy explaining how SK Ornaments collects, uses, and protects customer information.",
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