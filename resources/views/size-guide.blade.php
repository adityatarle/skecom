@extends('layout.header')

@section('title', 'Jewelry Size Guide - Ring, Bracelet & Necklace Sizing | SK Ornaments')
@section('description', 'Find your perfect jewelry size with our comprehensive size guide. Learn how to measure ring size, bracelet size, and necklace length. Get accurate sizing tips and charts.')
@section('keywords', 'jewelry size guide, ring size chart, bracelet size, necklace length, jewelry sizing, ring measurement, SK Ornaments size guide')

@section('og_title', 'Jewelry Size Guide - SK Ornaments')
@section('og_description', 'Find your perfect jewelry size with our comprehensive size guide. Learn how to measure ring size, bracelet size, and necklace length.')

<style>
    .size-guide-page {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .size-guide-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 0;
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .size-guide-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .size-guide-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .size-guide-content {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .size-section {
        background: white;
        border-radius: 15px;
        padding: 3rem;
        margin-bottom: 3rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .section-title {
        font-size: 2rem;
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
    
    .size-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: start;
    }
    
    .measurement-guide {
        background: #f8f9fa;
        padding: 2rem;
        border-radius: 15px;
        border-left: 4px solid #667eea;
    }
    
    .measurement-guide h3 {
        color: #333;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .measurement-steps {
        list-style: none;
        padding: 0;
    }
    
    .measurement-steps li {
        margin-bottom: 1rem;
        padding-left: 2rem;
        position: relative;
        line-height: 1.6;
        color: #555;
    }
    
    .measurement-steps li::before {
        content: counter(step-counter);
        counter-increment: step-counter;
        position: absolute;
        left: 0;
        top: 0;
        background: #667eea;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .measurement-steps {
        counter-reset: step-counter;
    }
    
    .size-chart {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .chart-header {
        background: #667eea;
        color: white;
        padding: 1rem;
        text-align: center;
        font-weight: 600;
    }
    
    .chart-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .chart-table th,
    .chart-table td {
        padding: 0.75rem;
        text-align: center;
        border-bottom: 1px solid #e9ecef;
    }
    
    .chart-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #333;
    }
    
    .chart-table tr:hover {
        background: #f8f9fa;
    }
    
    .size-tips {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-top: 2rem;
    }
    
    .size-tips h3 {
        margin-bottom: 1rem;
        font-size: 1.3rem;
    }
    
    .tips-list {
        list-style: none;
        padding: 0;
    }
    
    .tips-list li {
        margin-bottom: 0.8rem;
        padding-left: 1.5rem;
        position: relative;
    }
    
    .tips-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #28a745;
        font-weight: bold;
    }
    
    .interactive-tools {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }
    
    .tool-card {
        background: #f8f9fa;
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .tool-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .tool-icon {
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
    
    .tool-card h4 {
        color: #333;
        margin-bottom: 1rem;
        font-size: 1.3rem;
    }
    
    .tool-card p {
        color: #666;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    .tool-btn {
        background: #667eea;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
    }
    
    .tool-btn:hover {
        background: #5a6fd8;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .size-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .size-guide-hero h1 {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .size-section {
            padding: 2rem;
        }
        
        .chart-table {
            font-size: 0.9rem;
        }
        
        .chart-table th,
        .chart-table td {
            padding: 0.5rem;
        }
    }
</style>

<!-- Size Guide Page -->
<div class="size-guide-page">
    <!-- Hero Section -->
    <div class="size-guide-hero">
        <div class="container">
            <h1>Jewelry Size Guide</h1>
            <p>Find your perfect fit with our comprehensive jewelry sizing guide. Learn how to measure ring size, bracelet size, and necklace length.</p>
        </div>
    </div>

    <div class="container size-guide-content">
        <!-- Ring Size Guide -->
        <div class="size-section">
            <h2 class="section-title">Ring Size Guide</h2>
            <div class="size-grid">
                <div class="measurement-guide">
                    <h3>How to Measure Your Ring Size</h3>
                    <ol class="measurement-steps">
                        <li>Wrap a piece of string or paper around your finger</li>
                        <li>Mark where the string overlaps</li>
                        <li>Measure the length in millimeters</li>
                        <li>Use our chart to find your size</li>
                        <li>Measure at the end of the day when fingers are largest</li>
                        <li>Consider temperature and activity level</li>
                    </ol>
                    
                    <div class="size-tips">
                        <h3>Ring Sizing Tips</h3>
                        <ul class="tips-list">
                            <li>Measure your finger when it's at room temperature</li>
                            <li>Fingers are slightly larger in the evening</li>
                            <li>Consider seasonal changes in finger size</li>
                            <li>For wide bands, consider going up half a size</li>
                            <li>Knuckles may be larger than the base of your finger</li>
                        </ul>
                    </div>
                </div>
                
                <div class="size-chart">
                    <div class="chart-header">Ring Size Chart</div>
                    <table class="chart-table">
                        <thead>
                            <tr>
                                <th>US Size</th>
                                <th>UK Size</th>
                                <th>EU Size</th>
                                <th>Diameter (mm)</th>
                                <th>Circumference (mm)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>3</td><td>F</td><td>44</td><td>14.1</td><td>44.3</td></tr>
                            <tr><td>4</td><td>G</td><td>46</td><td>14.5</td><td>45.5</td></tr>
                            <tr><td>5</td><td>H</td><td>48</td><td>14.9</td><td>46.8</td></tr>
                            <tr><td>6</td><td>I</td><td>50</td><td>15.3</td><td>48.0</td></tr>
                            <tr><td>7</td><td>J</td><td>52</td><td>15.7</td><td>49.3</td></tr>
                            <tr><td>8</td><td>K</td><td>54</td><td>16.1</td><td>50.6</td></tr>
                            <tr><td>9</td><td>L</td><td>56</td><td>16.5</td><td>51.9</td></tr>
                            <tr><td>10</td><td>M</td><td>58</td><td>16.9</td><td>53.1</td></tr>
                            <tr><td>11</td><td>N</td><td>60</td><td>17.3</td><td>54.4</td></tr>
                            <tr><td>12</td><td>O</td><td>62</td><td>17.7</td><td>55.7</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bracelet Size Guide -->
        <div class="size-section">
            <h2 class="section-title">Bracelet Size Guide</h2>
            <div class="size-grid">
                <div class="measurement-guide">
                    <h3>How to Measure Your Wrist</h3>
                    <ol class="measurement-steps">
                        <li>Wrap a flexible measuring tape around your wrist</li>
                        <li>Measure at the widest part of your wrist</li>
                        <li>Keep the tape snug but not tight</li>
                        <li>Note the measurement in inches or centimeters</li>
                        <li>Add 0.5-1 inch for comfortable fit</li>
                        <li>Consider the bracelet style and closure</li>
                    </ol>
                    
                    <div class="size-tips">
                        <h3>Bracelet Sizing Tips</h3>
                        <ul class="tips-list">
                            <li>For bangles, measure across your knuckles</li>
                            <li>Chain bracelets should have some movement</li>
                            <li>Cuff bracelets should fit snugly</li>
                            <li>Consider your dominant hand size</li>
                            <li>Wrist size can vary throughout the day</li>
                        </ul>
                    </div>
                </div>
                
                <div class="size-chart">
                    <div class="chart-header">Bracelet Size Chart</div>
                    <table class="chart-table">
                        <thead>
                            <tr>
                                <th>Size</th>
                                <th>Wrist (inches)</th>
                                <th>Wrist (cm)</th>
                                <th>Bracelet Length</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>XS</td><td>5.5-6.0</td><td>14-15</td><td>6.5-7.0"</td></tr>
                            <tr><td>S</td><td>6.0-6.5</td><td>15-16.5</td><td>7.0-7.5"</td></tr>
                            <tr><td>M</td><td>6.5-7.0</td><td>16.5-18</td><td>7.5-8.0"</td></tr>
                            <tr><td>L</td><td>7.0-7.5</td><td>18-19</td><td>8.0-8.5"</td></tr>
                            <tr><td>XL</td><td>7.5-8.0</td><td>19-20.5</td><td>8.5-9.0"</td></tr>
                            <tr><td>XXL</td><td>8.0+</td><td>20.5+</td><td>9.0"+"</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Necklace Length Guide -->
        <div class="size-section">
            <h2 class="section-title">Necklace Length Guide</h2>
            <div class="size-grid">
                <div class="measurement-guide">
                    <h3>How to Choose Necklace Length</h3>
                    <ol class="measurement-steps">
                        <li>Measure your neck circumference</li>
                        <li>Consider your body type and height</li>
                        <li>Think about the neckline of your clothes</li>
                        <li>Consider the pendant or charm size</li>
                        <li>Try different lengths to find your preference</li>
                        <li>Layer multiple necklaces for style</li>
                    </ol>
                    
                    <div class="size-tips">
                        <h3>Necklace Styling Tips</h3>
                        <ul class="tips-list">
                            <li>Chokers work well with V-neck tops</li>
                            <li>Princess length is most versatile</li>
                            <li>Matinee length is perfect for business</li>
                            <li>Opera length can be doubled or worn long</li>
                            <li>Rope length is great for layering</li>
                        </ul>
                    </div>
                </div>
                
                <div class="size-chart">
                    <div class="chart-header">Necklace Length Chart</div>
                    <table class="chart-table">
                        <thead>
                            <tr>
                                <th>Length</th>
                                <th>Inches</th>
                                <th>CM</th>
                                <th>Best For</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Collar</td><td>14"</td><td>35.5</td><td>High necklines</td></tr>
                            <tr><td>Choker</td><td>16"</td><td>40.5</td><td>V-neck tops</td></tr>
                            <tr><td>Princess</td><td>18"</td><td>45.5</td><td>Most necklines</td></tr>
                            <tr><td>Matinee</td><td>20-24"</td><td>50.5-61</td><td>Business wear</td></tr>
                            <tr><td>Opera</td><td>28-34"</td><td>71-86</td><td>Evening wear</td></tr>
                            <tr><td>Rope</td><td>36-42"</td><td>91-107</td><td>Layering</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Interactive Tools -->
        <div class="size-section">
            <h2 class="section-title">Interactive Sizing Tools</h2>
            <div class="interactive-tools">
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="fas fa-ruler"></i>
                    </div>
                    <h4>Printable Ring Sizer</h4>
                    <p>Download and print our ring sizer to measure your finger size accurately at home.</p>
                    <a href="#" class="tool-btn">Download Sizer</a>
                </div>
                
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h4>Digital Ring Sizer</h4>
                    <p>Use your smartphone to measure your ring size with our digital tool.</p>
                    <a href="#" class="tool-btn">Try Digital Sizer</a>
                </div>
                
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h4>Size Converter</h4>
                    <p>Convert between different international sizing standards easily.</p>
                    <a href="#" class="tool-btn">Convert Sizes</a>
                </div>
                
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4>Expert Consultation</h4>
                    <p>Get personalized sizing advice from our jewelry experts.</p>
                    <a href="{{ route('contact') }}" class="tool-btn">Contact Expert</a>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="size-section">
            <h2 class="section-title">Additional Sizing Information</h2>
            <div class="size-grid">
                <div class="measurement-guide">
                    <h3>International Size Conversions</h3>
                    <p>Different countries use different sizing systems. Our charts show the most common conversions, but sizes may vary slightly between brands.</p>
                    
                    <h3>When to Re-measure</h3>
                    <ul class="tips-list">
                        <li>After significant weight changes</li>
                        <li>During pregnancy</li>
                        <li>After injury or surgery</li>
                        <li>Seasonal changes</li>
                        <li>Every few years for accuracy</li>
                    </ul>
                </div>
                
                <div class="measurement-guide">
                    <h3>Professional Sizing</h3>
                    <p>For the most accurate measurements, visit a professional jeweler. They have specialized tools and expertise to ensure perfect sizing.</p>
                    
                    <h3>Custom Sizing</h3>
                    <p>Many of our pieces can be custom-sized. Contact us for information about custom sizing options and lead times.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Structured Data for Size Guide -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Jewelry Size Guide - SK Ornaments",
    "description": "Comprehensive jewelry size guide including ring size, bracelet size, and necklace length measurements and charts.",
    "url": "{{ url('/size-guide') }}",
    "publisher": {
        "@type": "Organization",
        "name": "SK Ornaments",
        "url": "{{ url('/') }}"
    },
    "dateModified": "2025-02-15",
    "mainEntity": {
        "@type": "Article",
        "name": "Jewelry Size Guide",
        "description": "Complete guide to jewelry sizing including measurement instructions, size charts, and conversion tables.",
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