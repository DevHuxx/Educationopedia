/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { useState, useRef, useEffect } from "react";
import { fetchContentAll, fetchTestimonials as fetchTestimonialsAPI, fetchBlogPosts as fetchBlogPostsAPI, fetchUniversities, type Testimonial, type BlogPost as BlogPostAPI } from "@/lib/api";
import { Link } from "react-router-dom";
import { motion } from "framer-motion";
import {
  Users, Globe, Trophy, Star, ArrowRight, CheckCircle,
  GraduationCap, ChevronRight, Clock, Building2,
} from "lucide-react";
import { Button } from "@/components/ui/button";
import CounsellingCTA from "@/components/CounsellingCTA";
import HeroSection from "@/components/HeroSection";
import imgRussia from "@/assets/country-russia.jpg";
import imgTeamOffice from "@/assets/team-office.png";
import imgKazakhstan from "@/assets/country-kazakhstan.jpg";
import imgBangladesh from "@/assets/country-bangladesh.jpg";
import imgGeorgia from "@/assets/country-georgia.jpg";
import imgKyrgyzstan from "@/assets/country-kyrgyzstan.jpg";
import imgBlogMbbs from "@/assets/blog-mbbs-abroad.jpg";
import imgBlogNeet from "@/assets/blog-neet-score.jpg";
import imgBlogScholarship from "@/assets/blog-scholarship.jpg";

const stats = [
  { value: "10+", label: "Years Experience", icon: Trophy },
  { value: "1500+", label: "Students Placed", icon: Users },
  { value: "2000+", label: "Partner Universities", icon: GraduationCap },
  { value: "40+", label: "Countries", icon: Globe },
];

type CollegeRow = {
  id: number;
  rank: number;
  name: string;
  short: string;
  city: string;
  country: string;
  flag: string;
  rating: number;
  ranking: string;
  cutoff: string;
  deadline: string;
  fees: string;
};

const countryToISO = (country: string): string => {
  const map: Record<string, string> = {
    Russia: 'ru', Georgia: 'ge', Uzbekistan: 'uz', Kazakhstan: 'kz',
    Kyrgyzstan: 'kg', China: 'cn', Lithuania: 'lt', UK: 'gb',
    Nepal: 'np', Iran: 'ir', Bangladesh: 'bd',
    Malta: 'mt', Malaysia: 'my',
  };
  return map[country] ?? 'un';
};

const countryTabs = ["Nepal", "Russia", "Georgia", "Uzbekistan", "Kazakhstan", "Kyrgyzstan", "China", "Lithuania", "UK", "Iran", "Bangladesh", "Malaysia", "Malta", "Global"];

const studyPlaces = [
  { name: "Russia", desc: "200+ Students" },
  { name: "Georgia", desc: "200+ Students" },
  { name: "Uzbekistan", desc: "200+ Students" },
  { name: "Kazakhstan", desc: "100+ Students" },
  { name: "Kyrgyzstan", desc: "100+ Students" },
  { name: "China", desc: "100+ Students" },
  { name: "Lithuania", desc: "100+ Students" },
  { name: "UK", desc: "100+ Students" },
  { name: "Nepal", desc: "50+ Students" },
  { name: "Iran", desc: "50+ Students" },
  { name: "Bangladesh", desc: "50+ Students" },
];

type CourseTab = "MBBS" | "BDS" | "Nursing" | "Pharmacy" | "Engineering" | "Management";

const coursesByTab: Record<CourseTab, { name: string; duration: string; avgFees: string; colleges: string; type: string }[]> = {
  MBBS: [
    { name: "MBBS (Bachelor of Medicine)", duration: "6 Years", avgFees: "₹18–28 L", colleges: "120+", type: "Full Time" },
    { name: "MBBS in Russia", duration: "6 Years", avgFees: "₹20–30 L", colleges: "45+", type: "Full Time" },
    { name: "MBBS in Georgia", duration: "6 Years", avgFees: "₹22–28 L", colleges: "18+", type: "Full Time" },
    { name: "MBBS in Kazakhstan", duration: "5 Years", avgFees: "₹14–20 L", colleges: "22+", type: "Full Time" },
    { name: "MBBS in the UK", duration: "5 Years", avgFees: "₹25–45 L", colleges: "15+", type: "Full Time" },
    { name: "MBBS in Malta", duration: "5 Years", avgFees: "₹16–20 L", colleges: "3+", type: "Full Time" },
    { name: "MBBS in Malaysia", duration: "5 Years", avgFees: "₹6–11 L", colleges: "10+", type: "Full Time" },
  ],
  BDS: [
    { name: "BDS (Bachelor of Dental Surgery)", duration: "5 Years", avgFees: "₹14–22 L", colleges: "35+", type: "Full Time" },
    { name: "BDS in Nepal", duration: "5 Years", avgFees: "₹12–20 L", colleges: "8+", type: "Full Time" },
    { name: "BDS in China", duration: "5 Years", avgFees: "₹16–24 L", colleges: "10+", type: "Full Time" },
    { name: "BDS in the UK", duration: "5 Years", avgFees: "₹30–50 L", colleges: "12+", type: "Full Time" },
  ],
  Nursing: [
    { name: "BSc Nursing", duration: "4 Years", avgFees: "₹8–15 L", colleges: "60+", type: "Full Time" },
    { name: "MSc Nursing", duration: "2 Years", avgFees: "₹6–12 L", colleges: "40+", type: "Full Time" },
    { name: "General Nursing & Midwifery", duration: "3.5 Years", avgFees: "₹5–10 L", colleges: "30+", type: "Full Time" },
    { name: "Nursing in Lithuania", duration: "4 Years", avgFees: "₹12–18 L", colleges: "5+", type: "Full Time" },
  ],
  Pharmacy: [
    { name: "B.Pharm", duration: "4 Years", avgFees: "₹6–12 L", colleges: "35+", type: "Full Time" },
    { name: "D.Pharm", duration: "2 Years", avgFees: "₹3–6 L", colleges: "25+", type: "Full Time" },
    { name: "M.Pharm", duration: "2 Years", avgFees: "₹5–10 L", colleges: "20+", type: "Full Time" },
    { name: "Pharm.D", duration: "6 Years", avgFees: "₹10–18 L", colleges: "15+", type: "Full Time" },
  ],
  Engineering: [
    { name: "B.Tech / B.E", duration: "4 Years", avgFees: "₹12–22 L", colleges: "80+", type: "Full Time" },
    { name: "Computer Science – B.Tech", duration: "4 Years", avgFees: "₹15–25 L", colleges: "50+", type: "Full Time" },
    { name: "Mechanical Engineering", duration: "4 Years", avgFees: "₹12–20 L", colleges: "40+", type: "Full Time" },
    { name: "M.Tech / M.E", duration: "2 Years", avgFees: "₹10–18 L", colleges: "30+", type: "Full Time" },
  ],
  Management: [
    { name: "MBA (Master of Business Administration)", duration: "2 Years", avgFees: "₹10–20 L", colleges: "60+", type: "Full Time" },
    { name: "BBA", duration: "3 Years", avgFees: "₹8–15 L", colleges: "45+", type: "Full Time" },
    { name: "PGDM", duration: "2 Years", avgFees: "₹12–22 L", colleges: "30+", type: "Full Time" },
    { name: "Executive MBA", duration: "1.5 Years", avgFees: "₹15–28 L", colleges: "20+", type: "Part Time" },
  ],
};

const courseTabs: CourseTab[] = ["MBBS", "BDS", "Nursing", "Pharmacy", "Engineering", "Management"];

const topExams = [
  { name: "NEET UG", type: "Offline Exam", emoji: "📝", desc: "Required for MBBS/BDS admission abroad", color: "bg-blue-50 border-blue-200" },
  { name: "NEET PG", type: "Online Exam", emoji: "💻", desc: "For postgraduate medical admissions", color: "bg-green-50 border-green-200" },
  { name: "FMGE / MCI", type: "Online Exam", emoji: "🩺", desc: "Foreign Medical Graduate Exam", color: "bg-purple-50 border-purple-200" },
  { name: "USMLE", type: "Online Exam", emoji: "🌐", desc: "For practicing medicine in the USA", color: "bg-amber-50 border-amber-200" },
  { name: "PLAB", type: "Offline Exam", emoji: "🏥", desc: "Professional & Linguistic Assessments Board (UK)", color: "bg-rose-50 border-rose-200" },
  { name: "AMC", type: "Online Exam", emoji: "🦘", desc: "For medical registration in Australia", color: "bg-teal-50 border-teal-200" },
];

const countries = [
  { name: "Russia", flag: "🇷🇺", students: "200+", fees: "₹20-35L", image: "/count/russia.png" },
  { name: "Georgia", flag: "🇬🇪", students: "200+", fees: "₹20-30L", image: "/count/georgia.png" },
  { name: "Kazakhstan", flag: "🇰🇿", students: "100+", fees: "₹15-25L", image: "/count/kazakhstan.png" },
  { name: "Uzbekistan", flag: "🇺🇿", students: "200+", fees: "₹12-22L", image: "/count/uzbekistan.png" },
  { name: "Kyrgyzstan", flag: "🇰🇬", students: "100+", fees: "₹12-20L", image: "/count/kyrgyzstan.png" },
  { name: "Lithuania", flag: "🇱🇹", students: "100+", fees: "₹4L-6L", image: "/count/lithuania.png" },
  { name: "UK", flag: "🇬🇧", students: "100+", fees: "₹26L-53L", image: "/count/uk.png" },
  { name: "China", flag: "🇨🇳", students: "100+", fees: "₹18-35L", image: imgKazakhstan },
  { name: "Nepal", flag: "🇳🇵", students: "50+", fees: "₹15-28L", image: "/count/Nepal.png" },
  { name: "Iran", flag: "🇮🇷", students: "50+", fees: "₹20-30L", image: "/count/Iran.png" },
  { name: "Bangladesh", flag: "🇧🇩", students: "50+", fees: "₹25-40L", image: "/count/Bangladesh.png" },
];

const testimonials = [
  { name: "Sanjay Patel", course: "Admission in UK", text: "Thank you om and vishwarup sir for your kind support and guidance for my cousin brother admission in uk. You made my application process easy and stress free. I am truly happy and grateful for everything your company did.", rating: 5 },
  { name: "Happy Santpur", course: "MBBS in Georgia", text: "Thanks to the Educationopedia the whole admission and visa process was smooth for Mbbs in Georgia for March Intake. They helped me from document submission to airport pickup. Really appreciated Vishwarup & Om sir.", rating: 5 },
  { name: "Viola", course: "Career Guidance", text: "I was confused regarding my career options. After getting in touch with Educationopedia, they helped me analyse my options and gave guidance for the best path. Deepika mam's counselling really helped set a clear path for me.", rating: 5 },
  { name: "Sanjay Kumar", course: "Study Abroad", text: "I had good experience with this firm. The team specially om and vishwarup sir were extremely professional, supportive and transparent throughout entire admission process. From shortlisting university to accommodation support, everything was handled smoothly.", rating: 5 },
  { name: "Rajkumar Keshari", course: "MBBS Abroad", text: "Deepika madam's counselling for admission abroad in MBBS is excellent. I am highly impressed. Deepika has complete information about the admission process abroad.", rating: 5 },
  { name: "Girdhari lal", course: "Admission Process", text: "Thanku educationopedia team for being so transparent during my cousin brother admission process in Dubai also thanks to Om & Vishwarup Sir...God bless you all", rating: 5 },
];

const blogPosts = [
  { id: 1, title: "Top 10 Countries for MBBS Abroad in 2025", excerpt: "Discover the most popular and affordable destinations for pursuing MBBS abroad with recognized degrees.", date: "March 28, 2026", category: "MBBS Abroad", readTime: "5 min read", image: imgBlogMbbs },
  { id: 2, title: "NEET Score Requirements for Studying MBBS Abroad", excerpt: "Complete guide on minimum NEET scores required for admission in different countries for Indian students.", date: "March 25, 2026", category: "Admissions", readTime: "4 min read", image: imgBlogNeet },
  { id: 3, title: "Scholarship Opportunities for Indian Students Abroad", excerpt: "Explore various scholarship programs available for Indian students seeking international education.", date: "March 20, 2026", category: "Scholarships", readTime: "6 min read", image: imgBlogScholarship },
];

const ytReviews = [
  {
    videoId: "9FdDsTo6DyI",
    name: "KURUGUNTLA TULSINATH REDDY",
    location: "Andhra Pradesh",
    text: "Hi there, I wanted to let you all know that I used Educationopedia to reserve my seat at a Medical University. You can too!",
  },
  {
    videoId: "KvsxV6srP-E",
    name: "Vasundhara",
    location: "Lucknow",
    text: "Hi there, I wanted to let you all know that I used Educationopedia to reserve my seat at a Medical University in Georgia. You can too!",
  },
  {
    videoId: "kqfFXbiuyLw",
    name: "Shaza Osman",
    location: "Rampur",
    text: "Hello everyone, I highly recommend using Educationopedia to book your seat at a Medical University in Georgia, just like I did.",
  },
  {
    videoId: "qnhhPBYZM1E",
    name: "Unzila Saifi",
    location: "Uttarakhand",
    text: "Greetings all, I recently booked my seat at a Medical University in Georgia through Educationopedia. You can easily do the same!",
  },
];

const Index = () => {
  const [activeCountry, setActiveCountry] = useState<string>("Nepal");
  const [activeCourseTab, setActiveCourseTab] = useState<CourseTab>("MBBS");
  const [visibleCount, setVisibleCount] = useState<number>(10);
  const tabsRef = useRef<HTMLDivElement>(null);
  const courseTabsRef = useRef<HTMLDivElement>(null);

  
  const [cmsStats, setCmsStats] = useState(stats);
  const [cmsTestimonials, setCmsTestimonials] = useState(testimonials);
  const [cmsBlogPosts, setCmsBlogPosts] = useState<any[]>([]); 
  const [dynamicColleges, setDynamicColleges] = useState<Record<string, CollegeRow[]>>({});
  const [whyUsData, setWhyUsData] = useState<Record<string, string>>({});
  const [cmsError, setCmsError] = useState<string | null>(null);

  useEffect(() => {
    
    const cacheBust = `?_t=${Date.now()}`;
    console.log("[CMS] Initializing fresh data fetch...");

    fetchContentAll(['stats', 'why_us']).then((data) => {
      if (data && data.stats) {
        const s = data.stats;
        const newStats = [
          { value: s.stat_1_value || '10+', label: s.stat_1_label || 'Years Experience', icon: Trophy },
          { value: s.stat_2_value || '1500+', label: s.stat_2_label || 'Students Placed', icon: Users },
          { value: s.stat_3_value || '2000+', label: s.stat_3_label || 'Partner Universities', icon: GraduationCap },
          { value: s.stat_4_value || '40+', label: s.stat_4_label || 'Countries', icon: Globe },
        ];
        setCmsStats(newStats);
        setCmsError(null);
      }

      if (data && data.why_us) setWhyUsData(data.why_us);
    }).catch(err => {
      setCmsError("Connection failed. Check console.");
    });

    
    fetchTestimonialsAPI().then((data) => {
      if (data && data.length > 0) {
        setCmsTestimonials(data.map((t: Testimonial) => ({
          name: t.name,
          course: t.course,
          text: t.text,
          rating: Number(t.rating)
        })));
      }
    });

    
    fetchBlogPostsAPI(3).then((data) => {
      if (data && data.length > 0) {
        setCmsBlogPosts(data.map((post: BlogPostAPI) => ({
          id: post.id,
          title: post.title,
          excerpt: post.excerpt,
          category: post.category,
          readTime: post.read_time,
          image: post.image_path || "/blog-placeholder.jpg",
          date: post.published_at
        })));
      }
    });

    
    fetchUniversities().then((data) => {
      if (data && !Array.isArray(data)) {
        const dColleges: Record<string, CollegeRow[]> = {};
        for (const [country, unis] of Object.entries(data)) {
          dColleges[country] = unis.map((u: any) => ({
            id: Number(u.id),
            rank: Number(u.rank),
            name: u.name,
            short: u.short_name,
            city: u.city,
            country: u.country,
            flag: u.flag,
            rating: Number(u.rating),
            ranking: u.ranking_text,
            cutoff: u.cutoff,
            deadline: u.deadline,
            fees: u.fees
          }));
        }
        setDynamicColleges(dColleges);
      }
    });
  }, []);

  
  useEffect(() => {
    setVisibleCount(10);
  }, [activeCountry]);

  let colleges = dynamicColleges[activeCountry] ?? [];
  if (activeCountry === 'Global') {
    colleges = [...colleges].sort((a, b) => {
      let ia = countryTabs.indexOf(a.country);
      let ib = countryTabs.indexOf(b.country);
      if (ia === -1) ia = 999;
      if (ib === -1) ib = 999;
      return ia - ib;
    });
  } else {
    
    colleges = [...colleges].sort((a, b) => {
      const getRankNum = (rankingText: string) => {
        if (!rankingText) return 99999;
        const matches = rankingText.match(/\d+/g);
        if (!matches) return 99999;
        return Math.min(...matches.map(Number));
      };
      
      const rankA = getRankNum(a.ranking);
      const rankB = getRankNum(b.ranking);
      
      if (rankA === rankB) {
        return a.name.localeCompare(b.name);
      }
      return rankA - rankB;
    });
  }
  const displayedColleges = colleges.slice(0, visibleCount);

  return (
    <div>
      
      <HeroSection />

      
      <section className="py-12 bg-card border-b border-border">
        <div className="container mx-auto px-4">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
            {cmsStats.map((stat, i) => (
              <motion.div
                key={stat.label}
                initial={{ opacity: 0, scale: 0.8 }}
                whileInView={{ opacity: 1, scale: 1 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.1 }}
                className="text-center"
              >
                <stat.icon className="h-8 w-8 mx-auto mb-3 text-primary" />
                <div className="font-heading text-3xl md:text-4xl font-bold text-foreground">{stat.value}</div>
                <div className="text-sm text-muted-foreground mt-1">{stat.label}</div>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      
      <section className="py-16 bg-background border-b border-border">
        <div className="container mx-auto px-4">
          <h2 className="font-heading text-2xl md:text-3xl font-bold text-foreground mb-6">
            {activeCountry === 'Global' ? 'Top 10 Universities Abroad' : `Top Universities in ${activeCountry}`} for Indian Students
          </h2>

          
          <div className="relative flex items-center mb-6">
            <div
              ref={tabsRef}
              className="flex gap-2 overflow-x-auto pb-1 scrollbar-hide flex-1"
              style={{ scrollbarWidth: "none", msOverflowStyle: "none" }}
            >
              {countryTabs.map((c) => (
                <button
                  key={c}
                  onClick={() => setActiveCountry(c)}
                  className={`shrink-0 px-5 py-2 rounded-full text-sm font-medium border transition-all whitespace-nowrap ${activeCountry === c
                    ? "bg-foreground text-background border-foreground"
                    : "bg-background text-foreground border-border hover:border-primary hover:text-primary"
                    }`}
                >
                  {c}
                </button>
              ))}
            </div>
            <button
              onClick={() => tabsRef.current?.scrollBy({ left: 160, behavior: "smooth" })}
              className="ml-2 h-9 w-9 rounded-full border border-border bg-background flex items-center justify-center hover:bg-muted transition shrink-0"
            >
              <ChevronRight className="h-4 w-4 text-foreground" />
            </button>
          </div>

          
          <div className="overflow-x-auto rounded-xl border border-border">
            <table className="w-full text-sm">
              <thead>
                <tr className="bg-muted border-b border-border">
                  <th className="text-left px-4 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider w-16">Rank</th>
                  <th className="text-left px-4 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider">University</th>
                  <th className="text-left px-4 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider hidden md:table-cell">Ranking</th>
                  <th className="text-left px-4 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider hidden lg:table-cell">WHO / NMC / WDOMS</th>
                  <th className="text-left px-4 py-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider">Annual Fees</th>
                </tr>
              </thead>
              <tbody>
                {displayedColleges.map((col, i) => (
                  <motion.tr
                    key={`${activeCountry}-${col.id}`}
                    initial={{ opacity: 0, x: -10 }}
                    animate={{ opacity: 1, x: 0 }}
                    transition={{ delay: i * 0.04 }}
                    className={`border-b border-border hover:bg-primary/5 transition-colors ${i % 2 === 0 ? "bg-background" : "bg-muted/40"
                      }`}
                  >
                    
                    <td className="px-4 py-4 font-heading font-bold text-primary">#{i + 1}</td>

                    
                    <td className="px-4 py-4">
                      <div className="flex items-center gap-3">
                        <div className="h-10 w-10 rounded-full bg-white border border-border flex items-center justify-center shrink-0 overflow-hidden">
                          <img
                            src={`/logos/${col.name.toUpperCase()}.jpg`}
                            alt={col.country}
                            width={40}
                            height={40}
                            className="object-contain w-full h-full p-0.5"
                            onError={(e) => { 
                              const target = e.target as HTMLImageElement;
                              if (!target.src.includes('flagcdn')) {
                                target.src = `https://flagcdn.com/w40/${countryToISO(col.country)}.png`;
                                target.className = "object-cover w-full h-full";
                              } else {
                                target.style.display = 'none';
                              }
                            }}
                          />
                        </div>
                        <div>
                          <div className="font-semibold text-foreground leading-snug line-clamp-2 max-w-[240px]">
                            {col.name}
                          </div>
                          <div className="text-xs text-muted-foreground mt-0.5">
                            {col.city}, {col.country}
                          </div>
                        </div>
                      </div>
                    </td>

                    
                    <td className="px-4 py-4 hidden md:table-cell">
                      <div className="flex items-center gap-2">
                        <GraduationCap className="h-4 w-4 text-primary shrink-0" />
                        <span className="text-foreground text-xs leading-snug">{col.ranking}</span>
                      </div>
                    </td>

                    
                    <td className="px-4 py-4 hidden lg:table-cell">
                      <div className="flex flex-col gap-1">
                        <span className="inline-flex items-center gap-1 text-xs font-semibold text-emerald-400">
                          <CheckCircle className="h-3 w-3" /> WHO/FAIMER/NMC
                        </span>
                        <span className="inline-flex items-center gap-1 text-xs font-semibold text-emerald-400">
                          <CheckCircle className="h-3 w-3" /> WDOMS Listed
                        </span>
                      </div>
                    </td>

                    
                    <td className="px-4 py-4">
                      <span className="font-heading font-bold text-primary">{col.fees}</span>
                    </td>
                  </motion.tr>
                ))}
              </tbody>
            </table>
          </div>

          <div className="mt-5 flex justify-end gap-3">
            {colleges.length > visibleCount && (
              <Button
                variant="outline"
                size="sm"
                onClick={() => setVisibleCount(colleges.length)}
                className="font-heading border-primary text-primary hover:bg-primary hover:text-primary-foreground"
              >
                Load More <ChevronRight className="ml-2 h-4 w-4" />
              </Button>
            )}
            <Link to="/universities">
              <Button variant="outline" size="sm" className="font-heading border-primary text-primary hover:bg-primary hover:text-primary-foreground">
                View All Universities <ArrowRight className="ml-2 h-4 w-4" />
              </Button>
            </Link>
          </div>
        </div>
      </section>

      
      <section className="py-14 bg-muted border-b border-border">
        <div className="container mx-auto px-4">
          <h2 className="font-heading text-2xl md:text-3xl font-bold text-foreground mb-6">
            Top Study Destinations For MBBS Abroad
          </h2>
          <div className="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            {studyPlaces.map((place) => (
              <Link
                key={place.name}
                to={`/countries/${place.name.toLowerCase()}`}
                className="bg-white/80 backdrop-blur-sm border border-border/50 p-6 rounded-2xl text-center hover:-translate-y-2 transition-all hover:shadow-xl hover:shadow-primary/5 group"
              >
                <div className="mb-3 flex justify-center group-hover:scale-110 transition-transform">
                  <img src={`https://flagcdn.com/w40/${countryToISO(place.name)}.png`} alt={place.name} className="w-10 h-10 rounded-full object-cover shadow-sm" />
                </div>
                <h3 className="font-heading font-bold text-foreground mb-1">{place.name}</h3>
                <p className="text-sm text-muted-foreground">{place.desc}</p>
              </Link>
            ))}
          </div>
        </div>
      </section>

      
      <section className="py-16 bg-background border-b border-border">
        <div className="container mx-auto px-4">
          <h2 className="font-heading text-2xl md:text-3xl font-bold text-foreground mb-6">
            Explore Courses Abroad
          </h2>

          
          <div className="flex items-center gap-2 mb-8">
            <div
              ref={courseTabsRef}
              className="flex gap-2 overflow-x-auto pb-1"
              style={{ scrollbarWidth: "none", msOverflowStyle: "none" }}
            >
              {courseTabs.map((tab) => (
                <button
                  key={tab}
                  onClick={() => setActiveCourseTab(tab)}
                  className={`shrink-0 px-5 py-2 rounded-full text-sm font-medium border transition-all ${activeCourseTab === tab
                    ? "bg-foreground text-background border-foreground"
                    : "bg-background text-foreground border-border hover:border-primary hover:text-primary"
                    }`}
                >
                  {tab}
                </button>
              ))}
            </div>
          </div>

          
          <div className="flex gap-4 overflow-x-auto pb-2" style={{ scrollbarWidth: "none" }}>
            {coursesByTab[activeCourseTab].map((course, i) => (
              <motion.div
                key={course.name}
                initial={{ opacity: 0, y: 10 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: i * 0.07 }}
                className="shrink-0 w-64"
              >
                <Link
                  to="/courses"
                  className="block p-5 rounded-xl bg-card border border-border hover:border-primary hover:shadow-elevated transition-all h-full group"
                >
                  <span className="text-[10px] font-medium text-muted-foreground bg-muted px-2 py-0.5 rounded-full border border-border">
                    {course.type}
                  </span>
                  <h3 className="font-heading font-semibold text-foreground mt-3 mb-4 leading-snug group-hover:text-primary transition-colors">
                    {course.name}
                  </h3>
                  <div className="space-y-2 border-t border-border pt-3">
                    <div className="flex justify-between text-xs">
                      <span className="text-muted-foreground flex items-center gap-1.5"><Clock className="h-3.5 w-3.5" /> Duration</span>
                      <span className="font-semibold text-foreground">{course.duration}</span>
                    </div>
                    <div className="flex justify-between text-xs">
                      <span className="text-muted-foreground flex items-center gap-1.5"><GraduationCap className="h-3.5 w-3.5" /> Total Avg. Fees</span>
                      <span className="font-semibold text-foreground">{course.avgFees}</span>
                    </div>
                    <div className="flex justify-between text-xs">
                      <span className="text-muted-foreground flex items-center gap-1.5"><Building2 className="h-3.5 w-3.5" /> Universities</span>
                      <span className="font-semibold text-foreground">{course.colleges}</span>
                    </div>
                  </div>
                  <div className="flex items-center gap-1 mt-4 text-xs font-medium text-primary">
                    Course Overview <ChevronRight className="h-3.5 w-3.5" />
                  </div>
                </Link>
              </motion.div>
            ))}
          </div>

        </div>
      </section>

      
      <section className="py-16 bg-muted border-b border-border">
        <div className="container mx-auto px-4">
          <h2 className="font-heading text-2xl md:text-3xl font-bold text-foreground mb-2">
            Top Medical Entrance Exams
          </h2>
          <p className="text-muted-foreground text-sm mb-8">Clear these to study medicine at top universities abroad</p>
          <div className="flex gap-4 overflow-x-auto pb-2" style={{ scrollbarWidth: "none" }}>
            {topExams.map((exam, i) => (
              <motion.div
                key={exam.name}
                initial={{ opacity: 0, y: 10 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.07 }}
                className="shrink-0"
              >
                <Link
                  to="/courses"
                  className={`flex flex-col gap-3 w-52 p-5 rounded-xl border ${exam.color} hover:shadow-md transition-all group`}
                >
                  <div className="flex items-center gap-3">
                    <div className="h-11 w-11 rounded-full bg-white flex items-center justify-center text-xl shadow-sm">
                      {exam.emoji}
                    </div>
                    <div>
                      <p className="text-[10px] text-muted-foreground font-medium">{exam.type}</p>
                      <p className="font-heading font-bold text-foreground text-sm leading-tight">{exam.name}</p>
                    </div>
                  </div>
                  <p className="text-xs text-muted-foreground leading-relaxed">{exam.desc}</p>
                  <div className="flex items-center gap-1 text-xs font-medium text-primary mt-auto">
                    Learn More <ChevronRight className="h-3.5 w-3.5" />
                  </div>
                </Link>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      
      <section className="py-20 bg-background">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <span className="text-sm font-semibold text-primary uppercase tracking-wider">Your Dream Destination Awaits</span>
            <h2 className="font-heading text-3xl md:text-4xl font-bold text-foreground mt-2">
              Affordable MBBS Abroad Countries for Indian Students
            </h2>
            <p className="text-muted-foreground mt-3 max-w-2xl mx-auto">
              Don't let fees stop your child from becoming a doctor. These NMC-approved countries offer world-class medical education at a fraction of Indian private college costs.
            </p>
          </div>
          <div className="grid grid-cols-2 sm:grid-cols-3 gap-4">
            {countries.map((country, i) => (
              <motion.div
                key={country.name}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.05 }}
              >
                <Link
                  to={`/countries/${country.name.toLowerCase()}`}
                  className="block rounded-xl bg-card border border-border hover:border-primary hover:shadow-elevated transition-all group overflow-hidden"
                >
                  <div className="h-32 relative overflow-hidden">
                    <img src={country.image} alt={`Study in ${country.name}`} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" width={800} height={512} />
                    <div className="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent" />
                    <div className="absolute bottom-2 left-3 flex items-center gap-2">
                      <span className="text-2xl">{country.flag}</span>
                      <h3 className="font-heading font-semibold text-white text-sm">{country.name}</h3>
                    </div>
                  </div>
                  <div className="p-3 flex justify-between items-center text-xs">
                    <span className="text-muted-foreground">{country.students} Students</span>
                    <span className="font-semibold text-primary">{country.fees}</span>
                  </div>
                </Link>
              </motion.div>
            ))}
          </div>
          <div className="text-center mt-8">
            <Link to="/countries">
              <Button variant="outline" className="font-heading border-primary text-primary hover:bg-primary hover:text-primary-foreground">
                View All Countries <ArrowRight className="ml-2 h-4 w-4" />
              </Button>
            </Link>
          </div>
        </div>
      </section>

      
      <section className="py-20 bg-muted">
        <div className="container mx-auto px-4">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <span className="text-sm font-semibold text-primary uppercase tracking-wider">Why 1,500+ Families Chose Us</span>
              <h2 className="font-heading text-3xl md:text-4xl font-bold text-foreground mt-2 mb-4">
                {whyUsData.title || "We Don't Just Place Students — We Fulfil Family Dreams"}
              </h2>
              <p className="text-muted-foreground mb-6 leading-relaxed">{whyUsData.subtitle || "Every parent deserves to see their child in a white coat. We make that happen — honestly, affordably, and with care that feels personal because it is."}</p>
              <div className="space-y-4">
                {(whyUsData.points ? whyUsData.points.split('\n') : [
                  "Only NMC & WHO Approved Universities — Zero Risk",
                  "Complete Journey: Application → Visa → Hostel → Graduation",
                  "Honest Fees — No Hidden Charges, No Surprises",
                  "Scholarship Guidance That Actually Saves Lakhs",
                  "24/7 Student Helpline Even After You Land Abroad",
                  "Pre-departure Orientation So You're Never Alone",
                ]).map((item) => (
                  <div key={item} className="flex items-start gap-3">
                    <CheckCircle className="h-5 w-5 text-primary flex-shrink-0 mt-0.5" />
                    <span className="text-foreground">{item}</span>
                  </div>
                ))}
              </div>
              <Link to="/about" className="inline-block mt-8">
                <Button className="bg-primary text-primary-foreground hover:bg-primary-dark font-heading">
                  Learn More About Us <ArrowRight className="ml-2 h-4 w-4" />
                </Button>
              </Link>
            </div>
            <motion.div
              initial={{ opacity: 0, x: 30 }}
              whileInView={{ opacity: 1, x: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.6 }}
              className="relative rounded-2xl overflow-hidden shadow-elevated"
            >
              <img src={imgTeamOffice} alt="Educationopedia owner with students at the office" className="w-full h-auto object-cover rounded-2xl" loading="lazy" width={1568} height={588} />
              <div className="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/60 to-transparent p-6">
                <p className="text-white font-heading font-semibold text-sm md:text-base">Our team with students at the Educationopedia office</p>
              </div>
            </motion.div>
          </div>
        </div>
      </section>

      
      <section className="py-20 bg-background">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <span className="text-sm font-semibold text-primary uppercase tracking-wider">Real Stories, Real Tears of Joy</span>
            <h2 className="font-heading text-3xl md:text-4xl font-bold text-foreground mt-2">
              From NEET Heartbreak to White Coat — Their Words
            </h2>
          </div>
          <div className="grid md:grid-cols-3 gap-6">
            {cmsTestimonials.map((t, i) => (
              <motion.div
                key={t.name}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.1 }}
                className="p-6 rounded-xl bg-card border border-border shadow-card"
              >
                <div className="flex gap-1 mb-4">
                  {Array.from({ length: t.rating }).map((_, j) => (
                    <Star key={j} className="h-4 w-4 fill-accent text-accent" />
                  ))}
                </div>
                <p className="text-foreground text-sm leading-relaxed mb-4">"{t.text}"</p>
                <div>
                  <div className="font-heading font-semibold text-foreground">{t.name}</div>
                  <div className="text-xs text-muted-foreground">{t.course}</div>
                </div>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      
      <section className="py-20 bg-[#0d9488] text-white overflow-hidden">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="font-heading text-3xl md:text-4xl font-bold tracking-tight uppercase">
              STUDENTS REVIEWS
            </h2>
          </div>
          
          <div className="flex gap-6 overflow-x-auto pb-6 pt-2 px-4 scrollbar-hide snap-x" style={{ scrollbarWidth: "none" }}>
            {ytReviews.map((review) => (
              <motion.div
                key={review.videoId}
                className="shrink-0 w-80 bg-white text-gray-900 rounded-[24px] shadow-2xl p-4 flex flex-col justify-between snap-center"
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
              >
                
                <div className="flex items-center justify-between mb-3 px-1">
                  <div className="flex items-center gap-2">
                    <div className="h-8 w-8 rounded-full bg-[#0d9488] flex items-center justify-center text-white text-xs font-bold font-heading">
                      E
                    </div>
                    <div>
                      <div className="flex items-center gap-1">
                        <span className="font-bold text-xs">Educationopedia</span>
                        <svg className="h-3.5 w-3.5 text-blue-500 fill-current" viewBox="0 0 24 24">
                          <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                        </svg>
                      </div>
                    </div>
                  </div>
                  <div className="text-gray-400 cursor-pointer">
                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                      <circle cx="12" cy="5" r="2" />
                      <circle cx="12" cy="12" r="2" />
                      <circle cx="12" cy="19" r="2" />
                    </svg>
                  </div>
                </div>

                
                <div className="relative aspect-[9/16] h-[340px] w-full bg-black rounded-xl overflow-hidden mb-3">
                  <iframe
                    className="absolute inset-0 w-full h-full"
                    src={`https://www.youtube.com/embed/${review.videoId}`}
                    title={review.name}
                    frameBorder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowFullScreen
                  ></iframe>
                </div>

                
                <div className="flex items-center justify-between mb-3 px-1">
                  <div className="flex items-center gap-3 text-gray-700">
                    <svg className="w-5 h-5 text-red-500 fill-current" viewBox="0 0 24 24">
                      <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                    <svg className="w-5 h-5 hover:text-teal-500 cursor-pointer" fill="none" stroke="currentColor" strokeWidth="2.5" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <svg className="w-5 h-5 hover:text-teal-500 cursor-pointer" fill="none" stroke="currentColor" strokeWidth="2.5" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" d="M8.684 10.742l3.243-3.243m0 0l3.242 3.243m-3.242-3.243v11.666m-6-10.334A5.998 5.998 0 003 12c0 1.657.672 3.157 1.757 4.243m14.486-4.243A5.998 5.998 0 0121 12c0 1.657-.672 3.157-1.757 4.243" />
                    </svg>
                  </div>
                  <div className="text-gray-700">
                    <svg className="w-5 h-5 hover:text-teal-500 cursor-pointer" fill="none" stroke="currentColor" strokeWidth="2.5" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                  </div>
                </div>

                
                <div className="px-1 flex-1 flex flex-col justify-between">
                  <div>

                    <p className="text-[11px] text-gray-600 leading-relaxed mt-2">
                      {review.text}
                    </p>
                  </div>
                  <div className="border-t border-gray-100 pt-2.5 mt-3 flex justify-between items-center text-[10px] font-semibold text-teal-600">
                    <span>Call +91 85913 42044</span>
                    <span className="hover:underline">www.educationopedia.com</span>
                  </div>
                </div>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      
      <div className="fixed bottom-20 left-4 right-4 z-40 lg:hidden">
        <Link to="/contact">
          <Button className="w-full bg-primary text-primary-foreground font-heading font-semibold py-4 shadow-elevated text-base rounded-xl animate-pulse">
            📞 Book Free Counselling Now
          </Button>
        </Link>
      </div>

      
      <CounsellingCTA />
    </div>
  );
};

export default Index;
