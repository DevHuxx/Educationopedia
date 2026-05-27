/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { Link } from "react-router-dom";
import { motion } from "framer-motion";
import { MapPin, GraduationCap, Star, ArrowRight, Globe, DollarSign } from "lucide-react";
import { Button } from "@/components/ui/button";
import CounsellingCTA from "@/components/CounsellingCTA";

const universities = [
  { name: "Stavropol State University", country: "Russia", flag: "🇷🇺", courses: ["MBBS", "Engineering"], rating: 4.8, fees: "₹1.92 L/year", ranking: "Best Affordability", accreditation: "NMC, WHO", established: "1930" },
  { name: "Tbilisi State Medical University", country: "Georgia", flag: "🇬🇪", courses: ["MBBS", "Dentistry"], rating: 4.7, fees: "₹7L - ₹8L/year", ranking: "#1 in Georgia", accreditation: "NMC, WHO", established: "1918" },
  { name: "Al-Farabi Kazakh National Univ", country: "Kazakhstan", flag: "🇰🇿", courses: ["MBBS"], rating: 4.6, fees: "₹3.5L - ₹4.5L/year", ranking: "#1 in Kazakhstan", accreditation: "NMC, WHO", established: "1934" },
  { name: "Tashkent Medical Academy", country: "Uzbekistan", flag: "🇺🇿", courses: ["MBBS"], rating: 4.6, fees: "₹4L - ₹5L/year", ranking: "#1 in Uzbekistan", accreditation: "NMC, WHO", established: "1920" },
  { name: "Osh State University", country: "Kyrgyzstan", flag: "🇰🇬", courses: ["MBBS"], rating: 4.5, fees: "₹3L - ₹4L/year", ranking: "#3 in Kyrgyzstan", accreditation: "NMC, WHO", established: "1939" },
  { name: "Institute of Medicine (IOM)", country: "Nepal", flag: "🇳🇵", courses: ["MBBS"], rating: 4.9, fees: "₹11L - ₹12L/year", ranking: "#1 in Nepal", accreditation: "NMC, WHO", established: "1972" },
  { name: "Fudan University", country: "China", flag: "🇨🇳", courses: ["MBBS"], rating: 4.9, fees: "₹8.5L - ₹9.5L/year", ranking: "#3 in China", accreditation: "NMC, WHO", established: "1905" },
  { name: "Tehran University of Medical Sciences", country: "Iran", flag: "🇮🇷", courses: ["MBBS", "Pharmacy"], rating: 4.8, fees: "₹4.5L/year", ranking: "#1 in Iran", accreditation: "NMC, WHO", established: "1934" },
  { name: "Dhaka National Medical College", country: "Bangladesh", flag: "🇧🇩", courses: ["MBBS"], rating: 4.6, fees: "₹3.0L/year", ranking: "#1 in Bangladesh", accreditation: "NMC, WHO", established: "1925" },
  { name: "First Moscow State Medical University", country: "Russia", flag: "🇷🇺", courses: ["MBBS"], rating: 5.0, fees: "₹13.0 L/year", ranking: "#1 in Russia", accreditation: "NMC, WHO", established: "1758" },
];

const Universities = () => {
  return (
    <div>
      <section className="gradient-hero py-20">
        <div className="container mx-auto px-4 text-center">
          <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }}>
            <h1 className="font-heading text-4xl md:text-5xl font-bold text-primary-foreground mb-4">Top 10 Universities Abroad for Indian Students</h1>
            <p className="text-primary-foreground/80 text-lg max-w-2xl mx-auto">
              Explore 2000+ NMC & WHO approved universities across 40+ countries
            </p>
          </motion.div>
        </div>
      </section>

      <section className="py-16 bg-background">
        <div className="container mx-auto px-4">
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {universities.map((uni, i) => (
              <motion.div key={uni.name} initial={{ opacity: 0, y: 20 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }} transition={{ delay: i * 0.05 }} className="rounded-xl bg-card border border-border hover:shadow-elevated transition-all p-6 group">
                <div className="flex items-start justify-between mb-4">
                  <div className="flex items-center gap-2">
                    <span className="text-2xl">{uni.flag}</span>
                    <span className="text-xs text-muted-foreground">{uni.country}</span>
                  </div>
                </div>
                <h3 className="font-heading text-lg font-bold text-foreground group-hover:text-primary transition-colors mb-2">{uni.name}</h3>
                <div className="flex flex-wrap gap-1 mb-4">
                  {uni.courses.map((c) => (
                    <span key={c} className="text-xs px-2 py-1 rounded-full bg-primary-light text-primary font-medium">{c}</span>
                  ))}
                </div>
                <div className="space-y-2 mb-4">
                  <div className="flex items-center gap-2 text-sm">
                    <DollarSign className="h-3.5 w-3.5 text-primary" />
                    <span className="text-muted-foreground">Fees: <strong className="text-foreground">{uni.fees}</strong></span>
                  </div>
                  <div className="flex items-center gap-2 text-sm">
                    <Globe className="h-3.5 w-3.5 text-primary" />
                    <span className="text-muted-foreground">Ranking: <strong className="text-foreground">{uni.ranking}</strong></span>
                  </div>
                  <div className="flex items-center gap-2 text-sm">
                    <GraduationCap className="h-3.5 w-3.5 text-primary" />
                    <span className="text-muted-foreground">Accreditation: <strong className="text-foreground">{uni.accreditation}</strong></span>
                  </div>
                </div>
                <Link to="/contact">
                  <Button size="sm" className="w-full bg-primary text-primary-foreground hover:bg-primary-dark font-heading">
                    Apply Now <ArrowRight className="ml-2 h-3 w-3" />
                  </Button>
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

export default Universities;
