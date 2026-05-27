/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { motion } from "framer-motion";
import { Link } from "react-router-dom";
import { 
  Globe, Laptop, Briefcase, Scale, Palette, Utensils, 
  Plane, Newspaper, BookOpen, Leaf, Languages, ArrowRight, MapPin, Map, Star
} from "lucide-react";
import { Button } from "@/components/ui/button";
import CounsellingCTA from "@/components/CounsellingCTA";

const courses = [
  { name: "Engineering & Technology", icon: Laptop },
  { name: "Business & Management", icon: Briefcase },
  { name: "Computer Science & IT", icon: Laptop },
  { name: "Law", icon: Scale },
  { name: "Arts, Design & Creative", icon: Palette },
  { name: "Hospitality & Tourism", icon: Utensils },
  { name: "Aviation", icon: Plane },
  { name: "Journalism & Mass Comm.", icon: Newspaper },
  { name: "Humanities & Social Sciences", icon: BookOpen },
  { name: "Agriculture & Environmental", icon: Leaf },
  { name: "Languages & Teaching", icon: Languages },
];

const regions = [
  {
    title: "⭐ Popular Destinations",
    countries: ["United Kingdom", "Ireland", "New Zealand", "Australia", "United States", "South Korea"]
  },
  {
    title: "🇪🇺 Europe",
    countries: ["Germany", "Netherlands", "France", "Italy", "Spain", "Poland", "Hungary", "Czech Republic", "Slovakia", "Lithuania", "Latvia", "Estonia", "Romania", "Bulgaria", "Switzerland", "Cyprus", "Malta"]
  },
  {
    title: "🌏 Asia",
    countries: ["Malaysia", "Singapore", "Japan", "Indonesia"]
  },
  {
    title: "🌍 Middle East",
    countries: ["United Arab Emirates (Dubai)"]
  }
];

const StudyAbroad = () => {
  return (
    <div className="bg-background min-h-screen">
      
      <section className="relative bg-primary pt-24 pb-32 overflow-hidden">
        <div className="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center opacity-20 mix-blend-overlay"></div>
        <div className="absolute inset-0 bg-gradient-to-t from-background to-transparent"></div>
        <div className="container mx-auto px-4 relative z-10 text-center">
          <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.5 }}>
            <span className="inline-block py-1 px-3 rounded-full bg-white/10 text-white border border-white/20 text-sm font-semibold tracking-wide uppercase mb-6 backdrop-blur-md">
              Global Education Hub
            </span>
            <h1 className="font-heading text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
              Study Abroad with <span className="text-accent">Educationopedia</span>
            </h1>
            <p className="text-white/80 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
              Unlock a world of opportunities. Choose from top-ranked universities globally across multiple disciplines and shape your international career.
            </p>
            <Link to="/contact">
              <Button size="lg" className="bg-accent text-accent-foreground hover:bg-white hover:text-primary font-heading font-bold shadow-xl transition-all duration-300">
                Plan Your Journey <ArrowRight className="ml-2 h-5 w-5" />
              </Button>
            </Link>
          </motion.div>
        </div>
      </section>

      
      <section className="py-24 bg-card border-b border-border relative z-20 -mt-10 rounded-t-[3rem] shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
        <div className="container mx-auto px-4">
          <div className="text-center max-w-3xl mx-auto mb-16">
            <h2 className="font-heading text-3xl md:text-4xl font-bold text-foreground mb-4">
              Explore Academic Programs
            </h2>
            <p className="text-muted-foreground text-lg">
              Find the perfect degree that matches your career aspirations. We guide you through admissions for all major disciplines.
            </p>
          </div>
          
          <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            {courses.map((course, i) => (
              <motion.div
                key={course.name}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.05 }}
              >
                <div className="p-6 rounded-2xl bg-background border border-border hover:border-primary hover:shadow-elevated transition-all duration-300 group cursor-pointer h-full flex flex-col items-center text-center">
                  <div className="h-14 w-14 rounded-full bg-primary/10 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:bg-primary transition-all duration-300">
                    <course.icon className="h-6 w-6 text-primary group-hover:text-white" />
                  </div>
                  <h3 className="font-heading font-bold text-foreground group-hover:text-primary transition-colors">
                    {course.name}
                  </h3>
                </div>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      
      <section className="py-24 bg-muted">
        <div className="container mx-auto px-4">
          <div className="text-center max-w-3xl mx-auto mb-16">
            <div className="inline-flex items-center justify-center p-3 bg-primary/10 rounded-full mb-4">
              <Globe className="h-8 w-8 text-primary" />
            </div>
            <h2 className="font-heading text-3xl md:text-4xl font-bold text-foreground mb-4">
              Global Study Destinations
            </h2>
            <p className="text-muted-foreground text-lg">
              From the bustling streets of London to the tech hubs of Asia, discover top educational destinations worldwide.
            </p>
          </div>

          <div className="grid md:grid-cols-2 gap-10">
            {regions.map((region, idx) => (
              <motion.div 
                key={region.title}
                initial={{ opacity: 0, scale: 0.95 }}
                whileInView={{ opacity: 1, scale: 1 }}
                viewport={{ once: true }}
                transition={{ delay: idx * 0.1 }}
                className="bg-card rounded-3xl p-8 border border-border shadow-sm hover:shadow-md transition-shadow"
              >
                <h3 className="font-heading text-2xl font-bold text-foreground mb-6 flex items-center gap-3 border-b border-border pb-4">
                  {region.title}
                </h3>
                <div className="grid grid-cols-2 sm:grid-cols-3 gap-y-4 gap-x-2">
                  {region.countries.map(country => (
                    <div key={country} className="flex items-center gap-2 group">
                      <MapPin className="h-4 w-4 text-muted-foreground group-hover:text-primary transition-colors shrink-0" />
                      <span className="text-sm font-medium text-foreground/80 group-hover:text-primary transition-colors">
                        {country}
                      </span>
                    </div>
                  ))}
                </div>
              </motion.div>
            ))}
          </div>
          
          <div className="mt-16 text-center">
            <Link to="/contact">
              <Button variant="outline" size="lg" className="border-primary text-primary hover:bg-primary hover:text-white font-heading font-bold px-8">
                Request Detailed Brochure <BookOpen className="ml-2 h-5 w-5" />
              </Button>
            </Link>
          </div>
        </div>
      </section>

      
      <CounsellingCTA />
    </div>
  );
};

export default StudyAbroad;
