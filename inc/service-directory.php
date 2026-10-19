<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/** Current business service directory, in the requested menu order. */
function nsp_service_directory(): array {
    return [
        [ 'title'=>'Home Cleaning', 'ar'=>'تنظيف المنازل', 'group'=>'cleaning', 'desc'=>'Professional cleaning for a fresh, comfortable home.', 'desc_ar'=>'تنظيف احترافي لمنزل نظيف ومريح.' ],
        [ 'title'=>'Sofa Cleaning', 'previous_title'=>'Sofa Deep Cleaning', 'ar'=>'تنظيف عميق للكنب', 'group'=>'cleaning', 'desc'=>'Deep cleaning for sofa upholstery, cushions, and seating.', 'desc_ar'=>'تنظيف عميق لأقمشة الكنب والوسائد ومناطق الجلوس.' ],
        [ 'title'=>'Mattress Cleaning', 'ar'=>'تنظيف المراتب', 'group'=>'cleaning', 'desc'=>'Detailed cleaning and freshening for your mattresses.', 'desc_ar'=>'تنظيف دقيق للمراتب والعناية بنظافتها.' ],
        [ 'title'=>'Carpet & Rug Cleaning', 'ar'=>'تنظيف السجاد والموكيت', 'group'=>'cleaning', 'previous_title'=>'Carpet Cleaning', 'desc'=>'Deep cleaning for carpets and rugs throughout your space.', 'desc_ar'=>'تنظيف عميق للسجاد والموكيت في جميع أنحاء مساحتك.' ],
        [ 'title'=>'Apartment Cleaning', 'ar'=>'تنظيف الشقق', 'group'=>'cleaning', 'desc'=>'Room-by-room cleaning for apartments of different sizes.', 'desc_ar'=>'تنظيف غرف الشقق بمختلف أحجامها.' ],
        [ 'title'=>'Villa Cleaning', 'ar'=>'تنظيف الفلل', 'group'=>'cleaning', 'desc'=>'Cleaning for villa rooms, living areas, and shared spaces.', 'desc_ar'=>'تنظيف غرف الفلل ومناطق المعيشة والمساحات المشتركة.' ],
        [ 'title'=>'Kitchen Cleaning', 'ar'=>'تنظيف المطابخ', 'group'=>'cleaning', 'desc'=>'Detailed cleaning of kitchen surfaces, cabinets, and appliances.', 'desc_ar'=>'تنظيف دقيق لأسطح المطبخ والخزائن والأجهزة.' ],
        [ 'title'=>'Bathroom Cleaning', 'ar'=>'تنظيف الحمامات', 'group'=>'cleaning', 'desc'=>'Thorough cleaning of bathroom fixtures, tiles, and surfaces.', 'desc_ar'=>'تنظيف شامل لتجهيزات الحمام والبلاط والأسطح.' ],
        [ 'title'=>'Window & Glass Cleaning', 'ar'=>'تنظيف النوافذ والزجاج', 'group'=>'cleaning', 'desc'=>'Cleaning for accessible windows, glass panels, and mirrors.', 'desc_ar'=>'تنظيف النوافذ والألواح الزجاجية والمرايا التي يمكن الوصول إليها.' ],
        [ 'title'=>'Office Cleaning', 'ar'=>'تنظيف المكاتب والمنشآت التجارية', 'group'=>'commercial', 'previous_title'=>'Office & Commercial Cleaning', 'desc'=>'Professional cleaning for offices, workplaces, and commercial spaces.', 'desc_ar'=>'تنظيف احترافي للمكاتب وأماكن العمل والمساحات التجارية.' ],
        [ 'title'=>'Pest Control', 'ar'=>'مكافحة الحشرات', 'group'=>'pest', 'desc'=>'Pest inspection and treatment services tailored to your property.', 'desc_ar'=>'خدمات فحص ومكافحة الآفات حسب احتياجات عقارك.' ],
        [ 'title'=>'Bed Bug Treatment', 'ar'=>'مكافحة بق الفراش', 'group'=>'pest', 'desc'=>'Inspection and targeted treatment for bed bug concerns.', 'desc_ar'=>'فحص ومعالجة موجهة لمشكلة بق الفراش.' ],
        [ 'title'=>'Termite Control', 'ar'=>'مكافحة النمل الأبيض', 'group'=>'pest', 'desc'=>'Inspection and treatment planning for termite activity.', 'desc_ar'=>'فحص نشاط النمل الأبيض وتحديد خطة المكافحة.' ],
        [ 'title'=>'Ant Control', 'ar'=>'مكافحة النمل', 'group'=>'pest', 'desc'=>'Targeted ant control for affected rooms and entry points.', 'desc_ar'=>'مكافحة النمل في الغرف المتضررة ونقاط الدخول.' ],
        [ 'title'=>'Rat & Mouse Control', 'ar'=>'مكافحة الجرذان والفئران', 'group'=>'pest', 'desc'=>'Rodent inspection and control for homes and commercial spaces.', 'desc_ar'=>'فحص ومكافحة القوارض في المنازل والمنشآت التجارية.' ],
        [ 'title'=>'Mosquito Control', 'ar'=>'مكافحة البعوض', 'group'=>'pest', 'desc'=>'Mosquito control services based on your property needs.', 'desc_ar'=>'خدمات مكافحة البعوض حسب احتياجات عقارك.' ],
        [ 'title'=>'Fly Control', 'ar'=>'مكافحة الذباب', 'group'=>'pest', 'desc'=>'Inspection and fly control for affected indoor and outdoor areas.', 'desc_ar'=>'فحص ومكافحة الذباب في المناطق الداخلية والخارجية المتضررة.' ],
        [ 'title'=>'General Insect Control', 'ar'=>'المكافحة العامة للحشرات', 'group'=>'pest', 'desc'=>'Inspection and general insect treatment tailored to the problem.', 'desc_ar'=>'فحص ومعالجة عامة للحشرات حسب نوع المشكلة.' ],
        [ 'title'=>'Cockroach Treatment', 'ar'=>'مكافحة الصراصير', 'group'=>'pest', 'desc'=>'Targeted cockroach treatment for your property.', 'desc_ar'=>'معالجة الصراصير في عقارك.' ],
        [ 'title'=>'AC Services', 'previous_title'=>'AC Cleaning & Repair', 'ar'=>'خدمات المكيفات', 'group'=>'ac', 'desc'=>'Coil cleaning, servicing and drain clearing. Request a tailored price.', 'desc_ar'=>'تنظيف وصيانة المكيفات وتسليك التصريف. اطلب عرض سعر.' ],
        [ 'title'=>'Hourly Home Deep Cleaning', 'ar'=>'تنظيف المنزل بالساعة', 'group'=>'cleaning', 'desc'=>'Home deep cleaning at 45 SAR per hour, with a minimum booking of 3 hours.', 'desc_ar'=>'تنظيف عميق للمنزل بسعر ٤٥ ريال للساعة، بحد أدنى ٣ ساعات.' ],
        [ 'title'=>'Majlis Cleaning', 'ar'=>'تنظيف المجالس', 'group'=>'cleaning', 'desc'=>'Upholstery and floor seating cleaning for majlis halls. Price depends on size.', 'desc_ar'=>'تنظيف مفروشات وجلسات المجالس. السعر حسب المساحة.' ],
        [ 'title'=>'Car Detailing', 'previous_title'=>'Car Washing', 'ar'=>'تنظيف السيارات', 'group'=>'vehicle', 'desc'=>'Car seat extraction and interior detailing. Request a tailored price.', 'desc_ar'=>'تنظيف مقاعد وتفاصيل السيارة الداخلية. اطلب عرض سعر.' ],
        [ 'title'=>'Home Shifting', 'previous_title'=>'Home Shifting Service', 'ar'=>'نقل المنازل', 'group'=>'relocation', 'desc'=>'Residential relocation across Khobar, Dammam, Jubail and Ras Tanura.', 'desc_ar'=>'نقل المنازل في الخبر والدمام والجبيل ورأس تنورة.' ],
        [ 'title'=>'Water Tank Cleaning', 'ar'=>'تنظيف خزانات المياه', 'group'=>'maintenance', 'desc'=>'Water tank cleaning and sanitization to remove sediment, algae and residue.', 'desc_ar'=>'تنظيف وتعقيم خزانات المياه وإزالة الرواسب والطحالب.' ],
    ];
}
