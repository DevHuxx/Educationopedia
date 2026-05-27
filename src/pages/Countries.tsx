/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { Link, useParams } from "react-router-dom";
import { motion } from "framer-motion";
import { ArrowRight, MapPin, GraduationCap, DollarSign, Users, CheckCircle, Star, Clock, Thermometer } from "lucide-react";
import { Button } from "@/components/ui/button";
import CounsellingCTA from "@/components/CounsellingCTA";

import imgRussia from "@/assets/country-russia.jpg";
import imgKazakhstan from "@/assets/country-kazakhstan.jpg";
import imgBangladesh from "@/assets/country-bangladesh.jpg";
import imgGeorgia from "@/assets/country-georgia.jpg";
import imgKyrgyzstan from "@/assets/country-kyrgyzstan.jpg";

const countriesData: Record<string, {
  name: string; flag: string; tagline: string; desc: string; image: string;
  universities: number; students: string; avgFees: string; duration: string; language: string; climate: string; recognition: string;
  highlights: string[]; topUniversities: { name: string; ranking: string; fees: string }[];
  feeBreakdown: { item: string; cost: string }[];
  eligibility: string[];
}> = {
  russia: {
    name: "Russia", flag: "🇷🇺", tagline: "Top Destination for MBBS Abroad", image: imgRussia,
    desc: "Russia is one of the most preferred destinations for Indian students to pursue MBBS. With NMC-approved universities, affordable fees, and world-class medical education, Russia offers an excellent opportunity for aspiring doctors.",
    universities: 45, students: "1200+", avgFees: "₹20-35 Lakhs", duration: "6 Years", language: "English", climate: "-20°C to +30°C", recognition: "NMC, WHO, ECFMG",
    highlights: ["NMC & WHO Approved Universities", "No Entrance Exam Required", "English Medium Teaching", "Globally Recognized MD Degree", "Indian Food Available in Hostels", "Safe & Student-Friendly Environment"],
    topUniversities: [
      { name: "Kazan Federal University", ranking: "Top 200 Globally", fees: "₹4.5L/year" },
      { name: "Bashkir State Medical University", ranking: "100+ Years Legacy", fees: "₹3.8L/year" },
      { name: "Crimea Federal University", ranking: "Modern Campus", fees: "₹3.5L/year" },
      { name: "Orenburg State Medical University", ranking: "Strong Clinical", fees: "₹3.2L/year" },
      { name: "Volgograd State Medical University", ranking: "Research-Focused", fees: "₹3.0L/year" },
    ],
    feeBreakdown: [
      { item: "Tuition (6 years)", cost: "₹18-30 Lakhs" },
      { item: "Hostel", cost: "₹3-5 Lakhs" },
      { item: "Living Expenses", cost: "₹5-8 Lakhs" },
      { item: "Total Approximate", cost: "₹26-43 Lakhs" },
    ],
    eligibility: ["NEET Qualified", "50% in PCB (12th)", "Age 17+ at admission", "Valid passport"],
  },
  kazakhstan: {
    name: "Kazakhstan", flag: "🇰🇿", tagline: "Affordable Medical Education", image: imgKazakhstan,
    desc: "Kazakhstan has emerged as a popular destination for medical studies with its affordable tuition fees, modern infrastructure, and NMC-approved universities offering quality education.",
    universities: 20, students: "800+", avgFees: "₹15-25 Lakhs", duration: "5 Years", language: "English", climate: "-15°C to +35°C", recognition: "NMC, WHO",
    highlights: ["Low Tuition Fees", "NMC Recognized", "Modern Infrastructure", "English Medium", "Safe Environment", "Cultural Diversity"],
    topUniversities: [
      { name: "Kazakh National Medical University", ranking: "Top in Kazakhstan", fees: "₹3.5L/year" },
      { name: "Astana Medical University", ranking: "Capital City", fees: "₹3.2L/year" },
      { name: "Semey Medical University", ranking: "Established 1953", fees: "₹2.8L/year" },
      { name: "South Kazakhstan Medical Academy", ranking: "Regional Best", fees: "₹2.5L/year" },
      { name: "Al-Farabi Kazakh National University", ranking: "Top 200 QS", fees: "₹3.0L/year" },
    ],
    feeBreakdown: [
      { item: "Tuition (5 years)", cost: "₹12-18 Lakhs" },
      { item: "Hostel", cost: "₹2-3 Lakhs" },
      { item: "Living Expenses", cost: "₹3-5 Lakhs" },
      { item: "Total Approximate", cost: "₹17-26 Lakhs" },
    ],
    eligibility: ["NEET Qualified", "50% in PCB (12th)", "Age 17+", "Valid passport"],
  },
  bangladesh: {
    name: "Bangladesh", flag: "🇧🇩", tagline: "Nearest MBBS Abroad Destination", image: imgBangladesh,
    desc: "Bangladesh offers the closest international MBBS option for Indian students with similar culture, affordable fees, and NMC-approved medical universities.",
    universities: 12, students: "500+", avgFees: "₹15-25 Lakhs", duration: "5 Years", language: "English", climate: "15°C to 35°C", recognition: "NMC, WHO",
    highlights: ["Close to India", "Similar Culture", "NMC Approved", "Affordable Fees", "Easy Travel", "No Language Barrier"],
    topUniversities: [
      { name: "Dhaka National Medical College", ranking: "Top Rated", fees: "₹3.0L/year" },
      { name: "Sylhet MAG Osmani Medical College", ranking: "Government", fees: "₹2.5L/year" },
      { name: "Chittagong Medical College", ranking: "Established", fees: "₹2.8L/year" },
      { name: "Rajshahi Medical College", ranking: "Well-Known", fees: "₹2.5L/year" },
      { name: "Holy Family Red Crescent Medical College", ranking: "Private Top", fees: "₹3.2L/year" },
    ],
    feeBreakdown: [
      { item: "Tuition (5 years)", cost: "₹12-20 Lakhs" },
      { item: "Hostel", cost: "₹1.5-2.5 Lakhs" },
      { item: "Living Expenses", cost: "₹2-4 Lakhs" },
      { item: "Total Approximate", cost: "₹15-27 Lakhs" },
    ],
    eligibility: ["NEET Qualified", "50% in PCB (12th)", "Age 17+", "Valid passport"],
  },
  georgia: {
    name: "Georgia", flag: "🇬🇪", tagline: "European Medical Education", image: imgGeorgia,
    desc: "Georgia offers European standard medical education at affordable costs. With WHO and NMC approved universities, it's becoming a top choice for Indian medical students.",
    universities: 8, students: "400+", avgFees: "₹20-30 Lakhs", duration: "6 Years", language: "English", climate: "2°C to 30°C", recognition: "NMC, WHO, WFME",
    highlights: ["European Standard Education", "WHO & NMC Approved", "Affordable Fees", "English Medium", "Safe Country", "Rich Culture"],
    topUniversities: [
      { name: "Tbilisi State Medical University", ranking: "#1 in Georgia", fees: "₹4.5L/year" },
      { name: "David Tvildiani Medical University", ranking: "WFME Listed", fees: "₹4.0L/year" },
      { name: "European University", ranking: "Modern Campus", fees: "₹3.5L/year" },
      { name: "Caucasus International University", ranking: "Popular", fees: "₹3.2L/year" },
      { name: "New Vision University", ranking: "Growing", fees: "₹3.0L/year" },
    ],
    feeBreakdown: [
      { item: "Tuition (6 years)", cost: "₹18-27 Lakhs" },
      { item: "Hostel", cost: "₹3-4 Lakhs" },
      { item: "Living Expenses", cost: "₹4-6 Lakhs" },
      { item: "Total Approximate", cost: "₹25-37 Lakhs" },
    ],
    eligibility: ["NEET Qualified", "50% in PCB (12th)", "Age 17+", "Valid passport"],
  },
  kyrgyzstan: {
    name: "Kyrgyzstan", flag: "🇰🇬", tagline: "Budget-Friendly MBBS", image: imgKyrgyzstan,
    desc: "Kyrgyzstan is one of the most budget-friendly destinations for MBBS abroad. With NMC-approved universities and low living costs, it's ideal for students seeking quality education on a budget.",
    universities: 10, students: "350+", avgFees: "₹12-20 Lakhs", duration: "5 Years", language: "English", climate: "-5°C to +30°C", recognition: "NMC, WHO",
    highlights: ["Most Affordable Option", "NMC Recognized", "English Medium", "Indian Community", "Low Living Cost", "Easy Admission"],
    topUniversities: [
      { name: "Kyrgyz State Medical Academy", ranking: "#1 in Kyrgyzstan", fees: "₹2.5L/year" },
      { name: "Osh State University", ranking: "Established 1951", fees: "₹2.2L/year" },
      { name: "International School of Medicine", ranking: "Modern", fees: "₹2.8L/year" },
      { name: "Jalal-Abad State University", ranking: "Popular", fees: "₹2.0L/year" },
      { name: "Asian Medical Institute", ranking: "Growing", fees: "₹2.3L/year" },
    ],
    feeBreakdown: [
      { item: "Tuition (5 years)", cost: "₹10-14 Lakhs" },
      { item: "Hostel", cost: "₹1.5-2 Lakhs" },
      { item: "Living Expenses", cost: "₹2-4 Lakhs" },
      { item: "Total Approximate", cost: "₹13-20 Lakhs" },
    ],
    eligibility: ["NEET Qualified", "50% in PCB (12th)", "Age 17+", "Valid passport"],
  },
  uzbekistan: {
    name: "Uzbekistan", flag: "🇺🇿", tagline: "Emerging Medical Excellence", image: imgRussia,
    desc: "Uzbekistan is rapidly becoming a top choice for Indian students due to its high educational standards and modern medical infrastructure that follows international patterns.",
    universities: 15, students: "300+", avgFees: "₹14-22 Lakhs", duration: "6 Years", language: "English", climate: "-8°C to +38°C", recognition: "NMC, WHO",
    highlights: ["NMC Approved Universities", "English Medium Curriculum", "Affordable Living Costs", "Growing Indian Community", "Modern Clinical Facilities", "Rich History & Culture"],
    topUniversities: [
      { name: "Samarkand State Medical University", ranking: "Oldest in Uzbekistan", fees: "₹3.2L/year" },
      { name: "Tashkent State Dental Institute", ranking: "Modern Infrastructure", fees: "₹3.5L/year" },
      { name: "Bukhara State Medical Institute", ranking: "Highly Rated", fees: "₹2.8L/year" },
      { name: "Fergana State University", ranking: "Medical Center", fees: "₹2.5L/year" },
      { name: "Tashkent Medical Academy", ranking: "Capital City Best", fees: "₹3.8L/year" },
    ],
    feeBreakdown: [
      { item: "Tuition (6 years)", cost: "₹12-18 Lakhs" },
      { item: "Hostel", cost: "₹2.5-3.5 Lakhs" },
      { item: "Living Expenses", cost: "₹3-5 Lakhs" },
      { item: "Total Approximate", cost: "₹17-26 Lakhs" },
    ],
    eligibility: ["NEET Qualified", "50% in PCB (12th)", "Age 17+", "Valid passport"],
  },
  nepal: {
    name: "Nepal", flag: "🇳🇵", tagline: "Closest Medical Destination", image: imgBangladesh,
    desc: "Nepal offers the most convenient MBBS option for Indian students with its familiar culture, proximity, and medical education system that closely mirrors the Indian pattern.",
    universities: 12, students: "450+", avgFees: "₹30-50 Lakhs", duration: "5.5 Years", language: "English", climate: "10°C to 30°C", recognition: "NMC, WHO",
    highlights: ["No Visa Required for Indians", "Common Medical Pattern", "NMC Recognized", "Indian Faculty Members", "Similar Culture & Food", "Easy Land Travel"],
    topUniversities: [
      { name: "Tribhuvan University", ranking: "#1 in Nepal", fees: "₹4.5L/year" },
      { name: "Kathmandu University", ranking: "Leading Private", fees: "₹5.2L/year" },
      { name: "B.P. Koirala Institute", ranking: "Government Aid", fees: "₹4.0L/year" },
      { name: "Manipal College of Medical Sciences", ranking: "Renowned Group", fees: "₹6.0L/year" },
      { name: "Nepal Medical College", ranking: "Established", fees: "₹4.8L/year" },
    ],
    feeBreakdown: [
      { item: "Tuition (5.5 years)", cost: "₹25-40 Lakhs" },
      { item: "Hostel & Mess", cost: "₹4-6 Lakhs" },
      { item: "Living Expenses", cost: "₹2-4 Lakhs" },
      { item: "Total Approximate", cost: "₹31-50 Lakhs" },
    ],
    eligibility: ["NEET Qualified", "50% in PCB (12th)", "Valid ID (Passport/Aadhar)", "Age 17+"],
  },
  china: {
    name: "China", flag: "🇨🇳", tagline: "World-Class Medical Research", image: imgRussia,
    desc: "China offers cutting-edge medical technology and top-ranked universities globally, providing a competitive environment for aspiring medical professionals.",
    universities: 45, students: "1200+", avgFees: "₹20-35 Lakhs", duration: "6 Years", language: "English", climate: "-10°C to +35°C", recognition: "NMC, WHO",
    highlights: ["Global Top 500 Universities", "Advanced Lab Facilities", "International Curriculum", "Asian Medical Leader", "Diverse Clinical Cases", "Global Recognition"],
    topUniversities: [
      { name: "Fudan University", ranking: "Top 50 Globally", fees: "₹5.5L/year" },
      { name: "Zhejiang University", ranking: "Research Giant", fees: "₹5.0L/year" },
      { name: "Sichuan University", ranking: "Strong Medicine", fees: "₹4.5L/year" },
      { name: "Nanjing Medical University", ranking: "Highly Specialized", fees: "₹4.2L/year" },
      { name: "Jilin University", ranking: "Vast Hospital Network", fees: "₹3.8L/year" },
    ],
    feeBreakdown: [
      { item: "Tuition (6 years)", cost: "₹18-30 Lakhs" },
      { item: "Hostel", cost: "₹3-5 Lakhs" },
      { item: "Living Expenses", cost: "₹5-8 Lakhs" },
      { item: "Total Approximate", cost: "₹26-43 Lakhs" },
    ],
    eligibility: ["NEET Qualified", "70%+ in PCB (12th) Recommended", "Age 18-25", "Valid passport"],
  },
  iran: {
    name: "Iran", flag: "🇮🇷", tagline: "Center for Medical Excellence", image: imgRussia,
    desc: "Iran is one of the most advanced medical hubs in the Middle East, offering high-quality clinical training and globally recognized degrees at very competitive costs.",
    universities: 30, students: "150+", avgFees: "₹18-28 Lakhs", duration: "7 Years", language: "English", climate: "0°C to +40°C", recognition: "NMC, WHO",
    highlights: ["High Hospital Clinical Exposure", "NMC & WHO Approved", "Modern Innovation", "Affordable Living", "Safe Environment", "Top Global Specializations"],
    topUniversities: [
      { name: "Tehran University of Medical Sciences", ranking: "Top 500 Globally", fees: "₹4.5L/year" },
      { name: "Shiraz University of Medical Sciences", ranking: "Medical Pioneer", fees: "₹4.0L/year" },
      { name: "Isfahan University of Medical Sciences", ranking: "Historic Research", fees: "₹3.8L/year" },
      { name: "Mashhad University of Medical Sciences", ranking: "Top Clinical", fees: "₹3.5L/year" },
      { name: "Tabriz University of Medical Sciences", ranking: "Established", fees: "₹3.2L/year" },
    ],
    feeBreakdown: [
      { item: "Tuition (7 years)", cost: "₹15-22 Lakhs" },
      { item: "Hostel", cost: "₹2-4 Lakhs" },
      { item: "Living Expenses", cost: "₹4-6 Lakhs" },
      { item: "Total Approximate", cost: "₹21-32 Lakhs" },
    ],
    eligibility: ["NEET Qualified", "50% in PCB (12th)", "Valid Passport", "Age 17-25"],
  },
  lithuania: {
    name: "Lithuania", flag: "🇱🇹", tagline: "EU Medical Standards", image: imgRussia,
    desc: "Lithuania offers an incredible opportunity to study medicine in the European Union, combining high-quality training with global recognition.",
    universities: 5, students: "100+", avgFees: "₹45-55 Lakhs", duration: "6 Years", language: "English", climate: "-5°C to 25°C", recognition: "NMC, WHO, EU",
    highlights: ["European Union Degree", "NMC & WHO Approved", "High Clinical Exposure", "Schengen Visa Access", "Modern Facilities", "Global Practice"],
    topUniversities: [
      { name: "Vilnius University", ranking: "Top 400 Globally", fees: "₹8.5L/year" },
      { name: "Lithuanian University of Health Sciences", ranking: "Top Clinical", fees: "₹9.0L/year" },
    ],
    feeBreakdown: [
      { item: "Tuition (6 years)", cost: "₹40-50 Lakhs" },
      { item: "Hostel & Living", cost: "₹15-20 Lakhs" },
      { item: "Total Approximate", cost: "₹55-70 Lakhs" },
    ],
    eligibility: ["NEET Qualified", "60% in PCB (12th)", "Valid Passport", "Entrance Test"],
  },
  uk: {
    name: "UK", flag: "🇬🇧", tagline: "Prestigious Medical Training", image: imgGeorgia,
    desc: "The United Kingdom provides some of the world's most prestigious and sought-after medical degrees, opening doors to a global medical career.",
    universities: 30, students: "200+", avgFees: "₹1.5-2.5 Cr", duration: "5-6 Years", language: "English", climate: "0°C to 25°C", recognition: "GMC, NMC, WHO",
    highlights: ["Global Prestige", "Direct PLAB/MRCP pathways", "State-of-the-art hospitals", "No language barrier", "Research focused", "Excellent earning potential"],
    topUniversities: [
      { name: "University of Oxford", ranking: "Top 3 Globally", fees: "₹40L/year" },
      { name: "UCL Medical School", ranking: "Elite Clinical", fees: "₹38L/year" },
      { name: "King's College London", ranking: "Highly Ranked", fees: "₹35L/year" },
    ],
    feeBreakdown: [
      { item: "Tuition (5 years)", cost: "₹1.2-2.0 Crores" },
      { item: "Living Expenses", cost: "₹30-50 Lakhs" },
      { item: "Total Approximate", cost: "₹1.5-2.5 Crores" },
    ],
    eligibility: ["NEET Qualified", "UCAT/BMAT Score", "High Academic Score", "IELTS/TOEFL"],
  },
  malaysia: {
    name: "Malaysia", flag: "🇲🇾", tagline: "Asian Medical Hub", image: imgBangladesh,
    desc: "Malaysia offers a blend of world-class infrastructure and affordable fees with diverse clinical exposure and globally recognized degrees.",
    universities: 15, students: "100+", avgFees: "₹30-60 Lakhs", duration: "5 Years", language: "English", climate: "20°C to 35°C", recognition: "NMC, WHO",
    highlights: ["Twin Degree Options", "Close to India", "Affordable Cost", "Modern Campuses", "Safe Environment", "High-Tech Facilities"],
    topUniversities: [
      { name: "Taylor's University", ranking: "Top Private", fees: "₹12L/year" },
      { name: "Monash University Malaysia", ranking: "Global Standard", fees: "₹20L/year" },
    ],
    feeBreakdown: [
      { item: "Tuition (5 years)", cost: "₹25-50 Lakhs" },
      { item: "Living Expenses", cost: "₹10-15 Lakhs" },
      { item: "Total Approximate", cost: "₹35-65 Lakhs" },
    ],
    eligibility: ["NEET Qualified", "50% in PCB (12th)", "Valid Passport", "IELTS"],
  },
  malta: {
    name: "Malta", flag: "🇲🇹", tagline: "European Degree Pathway", image: imgRussia,
    desc: "Malta is an excellent gateway to European medical practice, offering degrees from top universities like Queen Mary University of London.",
    universities: 3, students: "50+", avgFees: "₹1.2-1.5 Cr", duration: "5 Years", language: "English", climate: "10°C to 30°C", recognition: "NMC, WHO, EU",
    highlights: ["EU Recognized Degree", "UK Curriculum", "English Speaking", "Beautiful Campus", "High Quality of Life", "Global Network"],
    topUniversities: [
      { name: "Queen Mary University of London, Malta", ranking: "Prestigious UK Campus", fees: "₹35L/year" },
    ],
    feeBreakdown: [
      { item: "Tuition (5 years)", cost: "₹1.0-1.2 Crores" },
      { item: "Living Expenses", cost: "₹20-30 Lakhs" },
      { item: "Total Approximate", cost: "₹1.2-1.5 Crores" },
    ],
    eligibility: ["NEET Qualified", "UCAT Score", "High Academics", "Valid Passport"],
  },
};

const allCountries = Object.entries(countriesData).map(([slug, data]) => ({ slug, ...data }));

const Countries = () => {
  const { countrySlug } = useParams();

  if (countrySlug && countriesData[countrySlug]) {
    const country = countriesData[countrySlug];
    return (
      <div>
        
        <section className="relative py-20 overflow-hidden">
          <div className="absolute inset-0">
            <img src={country.image} alt={`Study in ${country.name}`} className="w-full h-full object-cover" width={800} height={512} />
            <div className="absolute inset-0 gradient-hero opacity-85" />
          </div>
          <div className="container mx-auto px-4 text-center relative z-10">
            <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }}>
              <span className="text-6xl mb-4 block">{country.flag}</span>
              <h1 className="font-heading text-4xl md:text-5xl font-bold text-primary-foreground mb-2">Study MBBS in {country.name}</h1>
              <p className="text-primary-foreground/80 text-lg">{country.tagline}</p>
            </motion.div>
          </div>
        </section>

        
        <section className="py-4 bg-card border-b border-border">
          <div className="container mx-auto px-4">
            <div className="flex flex-wrap justify-center gap-6 md:gap-12 text-sm">
              <div className="flex items-center gap-2"><Clock className="h-4 w-4 text-primary" /><span className="text-foreground font-medium">{country.duration} Duration</span></div>
              <div className="flex items-center gap-2"><GraduationCap className="h-4 w-4 text-primary" /><span className="text-foreground font-medium">{country.recognition}</span></div>
              <div className="flex items-center gap-2"><DollarSign className="h-4 w-4 text-primary" /><span className="text-foreground font-medium">{country.avgFees} Total</span></div>
              <div className="flex items-center gap-2"><Thermometer className="h-4 w-4 text-primary" /><span className="text-foreground font-medium">{country.climate}</span></div>
            </div>
          </div>
        </section>

        <section className="py-16 bg-background">
          <div className="container mx-auto px-4">
            <div className="grid lg:grid-cols-3 gap-8">
              <div className="lg:col-span-2 space-y-8">
                <div className="bg-card rounded-xl border border-border p-6 shadow-card">
                  <h2 className="font-heading text-2xl font-bold text-foreground mb-4">About MBBS in {country.name}</h2>
                  <p className="text-foreground/80 leading-relaxed">{country.desc}</p>
                </div>

                <div className="bg-card rounded-xl border border-border p-6 shadow-card">
                  <h3 className="font-heading text-xl font-bold text-foreground mb-4">Why Study in {country.name}?</h3>
                  <div className="grid sm:grid-cols-2 gap-3">
                    {country.highlights.map((h) => (
                      <div key={h} className="flex items-center gap-2">
                        <CheckCircle className="h-4 w-4 text-primary flex-shrink-0" />
                        <span className="text-sm text-foreground/80">{h}</span>
                      </div>
                    ))}
                  </div>
                </div>

                
                <div className="bg-card rounded-xl border border-border p-6 shadow-card">
                  <h3 className="font-heading text-xl font-bold text-foreground mb-4">Top Universities in {country.name}</h3>
                  <div className="overflow-x-auto">
                    <table className="w-full text-sm">
                      <thead>
                        <tr className="border-b border-border">
                          <th className="text-left py-3 px-2 font-heading font-semibold text-foreground">#</th>
                          <th className="text-left py-3 px-2 font-heading font-semibold text-foreground">University</th>
                          <th className="text-left py-3 px-2 font-heading font-semibold text-foreground">Highlight</th>
                          <th className="text-left py-3 px-2 font-heading font-semibold text-foreground">Fees/Year</th>
                        </tr>
                      </thead>
                      <tbody>
                        {country.topUniversities.map((uni, i) => (
                          <tr key={uni.name} className="border-b border-border/50 hover:bg-muted/50 transition-colors">
                            <td className="py-3 px-2 font-heading font-bold text-primary">{i + 1}</td>
                            <td className="py-3 px-2">
                              <div className="flex items-center gap-2">
                                <GraduationCap className="h-4 w-4 text-primary flex-shrink-0" />
                                <span className="font-medium text-foreground">{uni.name}</span>
                              </div>
                            </td>
                            <td className="py-3 px-2 text-muted-foreground">{uni.ranking}</td>
                            <td className="py-3 px-2 font-semibold text-primary">{uni.fees}</td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>
                </div>

                
                <div className="bg-card rounded-xl border border-border p-6 shadow-card">
                  <h3 className="font-heading text-xl font-bold text-foreground mb-4">Fee Structure Breakdown</h3>
                  <div className="space-y-3">
                    {country.feeBreakdown.map((item, i) => (
                      <div key={item.item} className={`flex justify-between items-center p-3 rounded-lg ${i === country.feeBreakdown.length - 1 ? 'bg-primary/10 border border-primary/20' : 'bg-muted'}`}>
                        <span className={`text-sm ${i === country.feeBreakdown.length - 1 ? 'font-bold text-foreground' : 'text-foreground/80'}`}>{item.item}</span>
                        <span className={`font-heading font-bold ${i === country.feeBreakdown.length - 1 ? 'text-primary text-lg' : 'text-foreground'}`}>{item.cost}</span>
                      </div>
                    ))}
                  </div>
                </div>

                
                <div className="bg-card rounded-xl border border-border p-6 shadow-card">
                  <h3 className="font-heading text-xl font-bold text-foreground mb-4">Eligibility Criteria</h3>
                  <div className="grid sm:grid-cols-2 gap-3">
                    {country.eligibility.map((e) => (
                      <div key={e} className="flex items-center gap-2 p-3 rounded-lg bg-muted">
                        <CheckCircle className="h-4 w-4 text-primary flex-shrink-0" />
                        <span className="text-sm text-foreground">{e}</span>
                      </div>
                    ))}
                  </div>
                </div>
              </div>

              <div className="space-y-6">
                <div className="bg-card rounded-xl border border-border p-6 shadow-card sticky top-24">
                  <h3 className="font-heading font-bold text-foreground mb-4">Quick Facts</h3>
                  <div className="space-y-4">
                    <div className="flex items-center gap-3">
                      <GraduationCap className="h-5 w-5 text-primary" />
                      <div>
                        <div className="text-xs text-muted-foreground">Universities</div>
                        <div className="font-semibold text-foreground">{country.universities}+ Partner Universities</div>
                      </div>
                    </div>
                    <div className="flex items-center gap-3">
                      <Users className="h-5 w-5 text-primary" />
                      <div>
                        <div className="text-xs text-muted-foreground">Students Placed</div>
                        <div className="font-semibold text-foreground">{country.students} Students</div>
                      </div>
                    </div>
                    <div className="flex items-center gap-3">
                      <DollarSign className="h-5 w-5 text-primary" />
                      <div>
                        <div className="text-xs text-muted-foreground">Average Fees (Total)</div>
                        <div className="font-semibold text-foreground">{country.avgFees}</div>
                      </div>
                    </div>
                    <div className="flex items-center gap-3">
                      <Clock className="h-5 w-5 text-primary" />
                      <div>
                        <div className="text-xs text-muted-foreground">Course Duration</div>
                        <div className="font-semibold text-foreground">{country.duration}</div>
                      </div>
                    </div>
                    <div className="flex items-center gap-3">
                      <Star className="h-5 w-5 text-primary" />
                      <div>
                        <div className="text-xs text-muted-foreground">Recognition</div>
                        <div className="font-semibold text-foreground">{country.recognition}</div>
                      </div>
                    </div>
                  </div>
                  <Link to="/contact" className="block mt-6">
                    <Button className="w-full bg-primary text-primary-foreground hover:bg-primary/90 font-heading py-5">
                      Get Free Counselling <ArrowRight className="ml-2 h-4 w-4" />
                    </Button>
                  </Link>
                  <a href="tel:+918591342044" className="block mt-3">
                    <Button variant="outline" className="w-full border-primary text-primary hover:bg-primary hover:text-primary-foreground font-heading py-5">
                      📞 Call +91 85913 42044
                    </Button>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </section>

        
        <section className="py-12 bg-muted">
          <div className="container mx-auto px-4">
            <h3 className="font-heading text-2xl font-bold text-foreground mb-6 text-center">Explore Other Countries</h3>
            <div className="grid grid-cols-2 md:grid-cols-5 gap-4">
              {allCountries.filter(c => c.slug !== countrySlug).map(c => (
                <Link key={c.slug} to={`/countries/${c.slug}`} className="flex items-center gap-3 p-3 rounded-xl bg-card border border-border hover:border-primary transition-all group">
                  <span className="text-2xl">{c.flag}</span>
                  <span className="font-heading font-semibold text-sm text-foreground group-hover:text-primary">{c.name}</span>
                </Link>
              ))}
            </div>
          </div>
        </section>

        <CounsellingCTA />
      </div>
    );
  }

  
  return (
    <div>
      <section className="gradient-hero py-20">
        <div className="container mx-auto px-4 text-center">
          <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }}>
            <h1 className="font-heading text-4xl md:text-5xl font-bold text-primary-foreground mb-4">Study Abroad Countries</h1>
            <p className="text-primary-foreground/80 text-lg max-w-2xl mx-auto">
              Explore top destinations for quality MBBS education at affordable fees
            </p>
          </motion.div>
        </div>
      </section>

      
      <section className="py-12 bg-card border-b border-border">
        <div className="container mx-auto px-4">
          <h2 className="font-heading text-2xl font-bold text-foreground mb-6 text-center">Compare Countries at a Glance</h2>
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead>
                <tr className="border-b-2 border-primary/20">
                  <th className="text-left py-3 px-3 font-heading font-semibold text-foreground">Country</th>
                  <th className="text-left py-3 px-3 font-heading font-semibold text-foreground">Duration</th>
                  <th className="text-left py-3 px-3 font-heading font-semibold text-foreground">Total Fees</th>
                  <th className="text-left py-3 px-3 font-heading font-semibold text-foreground">Universities</th>
                  <th className="text-left py-3 px-3 font-heading font-semibold text-foreground">Recognition</th>
                  <th className="text-center py-3 px-3 font-heading font-semibold text-foreground">Action</th>
                </tr>
              </thead>
              <tbody>
                {allCountries.map((c) => (
                  <tr key={c.slug} className="border-b border-border/50 hover:bg-muted/50 transition-colors">
                    <td className="py-3 px-3">
                      <div className="flex items-center gap-2">
                        <span className="text-xl">{c.flag}</span>
                        <span className="font-medium text-foreground">{c.name}</span>
                      </div>
                    </td>
                    <td className="py-3 px-3 text-muted-foreground">{c.duration}</td>
                    <td className="py-3 px-3 font-semibold text-primary">{c.avgFees}</td>
                    <td className="py-3 px-3 text-muted-foreground">{c.universities}+</td>
                    <td className="py-3 px-3 text-muted-foreground">{c.recognition}</td>
                    <td className="py-3 px-3 text-center">
                      <Link to={`/countries/${c.slug}`}>
                        <Button size="sm" variant="outline" className="border-primary text-primary hover:bg-primary hover:text-primary-foreground text-xs">
                          View Details
                        </Button>
                      </Link>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <section className="py-20 bg-background">
        <div className="container mx-auto px-4">
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {allCountries.map((country, i) => (
              <motion.div
                key={country.slug}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.05 }}
              >
                <Link
                  to={`/countries/${country.slug}`}
                  className="block rounded-xl bg-card border border-border hover:border-primary hover:shadow-elevated transition-all overflow-hidden group"
                >
                  <div className="h-44 relative overflow-hidden">
                    <img src={country.image} alt={`Study in ${country.name}`} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" width={800} height={512} />
                    <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent" />
                    <div className="absolute bottom-4 left-4 flex items-center gap-3">
                      <span className="text-3xl">{country.flag}</span>
                      <div>
                        <h3 className="font-heading text-xl font-bold text-white">{country.name}</h3>
                        <p className="text-xs text-white/80">{country.tagline}</p>
                      </div>
                    </div>
                  </div>
                  <div className="p-5">
                    <div className="grid grid-cols-3 gap-3 mb-4">
                      <div className="text-center p-2 rounded-lg bg-muted">
                        <div className="font-heading font-bold text-foreground">{country.universities}+</div>
                        <div className="text-xs text-muted-foreground">Universities</div>
                      </div>
                      <div className="text-center p-2 rounded-lg bg-muted">
                        <div className="font-heading font-bold text-foreground">{country.students}</div>
                        <div className="text-xs text-muted-foreground">Students</div>
                      </div>
                      <div className="text-center p-2 rounded-lg bg-muted">
                        <div className="font-heading font-bold text-primary text-xs">{country.avgFees.split(' ')[0]}</div>
                        <div className="text-xs text-muted-foreground">Total Fees</div>
                      </div>
                    </div>
                    <div className="flex items-center justify-between text-primary text-sm font-medium">
                      <span>Explore Universities</span>
                      <ArrowRight className="h-4 w-4 group-hover:translate-x-1 transition-transform" />
                    </div>
                  </div>
                </Link>
              </motion.div>
            ))}
          </div>
        </div>
      </section>
      <CounsellingCTA />
    </div>
  );
};

export default Countries;
