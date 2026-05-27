/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { useEffect } from "react";
import { Link, useParams } from "react-router-dom";
import { motion } from "framer-motion";
import { ArrowRight, Clock, GraduationCap, DollarSign, Globe } from "lucide-react";
import { Button } from "@/components/ui/button";
import CounsellingCTA from "@/components/CounsellingCTA";

const allCourses = [
  {
    name: "MBBS",
    slug: "mbbs",
    icon: "🩺",
    desc: "Bachelor of Medicine, Bachelor of Surgery",
    duration: "5-6 Years",
    fees: "₹15-40 Lakhs",
    countries: "Russia, Kazakhstan, Bangladesh, Georgia, The UK",
    details: "MBBS abroad is the most popular choice for Indian medical aspirants. Study at NMC/WHO approved universities with globally recognized degrees.",
    highlights: ["NMC & WHO Approved", "Clinical Training Included", "No Donation / Capitation Fee", "English Medium Teaching"],
  },

  {
    name: "Nursing",
    slug: "nursing",
    icon: "💉",
    desc: "BSc / MSc Nursing Programs",
    duration: "3-4 Years",
    fees: "₹5-15 Lakhs",
    countries: "Bangladesh, Nepal, Lithuania",
    details: "Build a rewarding career in healthcare with internationally recognized nursing qualifications and clinical experience.",
    highlights: ["Clinical Rotations", "International Licensure", "High Demand Career", "Hands-on Training"],
  },
  {
    name: "Pharmacy",
    slug: "pharmacy",
    icon: "💊",
    desc: "B.Pharm / D.Pharm Programs",
    duration: "4 Years",
    fees: "₹8-20 Lakhs",
    countries: "Russia, Kazakhstan, Uzbekistan",
    details: "Study pharmaceutical sciences at leading universities with modern labs and research-oriented curriculum.",
    highlights: ["Research Opportunities", "Industry Internships", "Global Recognition", "Modern Laboratories"],
  },
  {
    name: "Dentistry",
    slug: "dentistry",
    icon: "🦷",
    desc: "BDS Programs Abroad",
    duration: "5 Years",
    fees: "₹15-35 Lakhs",
    countries: "Russia, Bangladesh, Georgia, The UK",
    details: "Pursue dentistry at internationally accredited universities with comprehensive clinical training and modern dental facilities.",
    highlights: ["Accredited Programs", "Clinical Practice", "Modern Equipment", "Global Career Scope"],
  },
];

const Courses = () => {
  const { courseSlug } = useParams();

  useEffect(() => {
    if (courseSlug) {
      const element = document.getElementById(courseSlug);
      if (element) {
        setTimeout(() => {
          element.scrollIntoView({ behavior: "smooth", block: "center" });
        }, 100);
      }
    }
  }, [courseSlug]);

  return (
    <div>
      
      <section className="gradient-hero py-20">
        <div className="container mx-auto px-4 text-center">
          <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.6 }}>
            <h1 className="font-heading text-4xl md:text-5xl font-bold text-primary-foreground mb-4">Our Courses</h1>
            <p className="text-primary-foreground/80 text-lg max-w-2xl mx-auto">
              Explore a wide range of internationally recognized courses across top universities worldwide
            </p>
          </motion.div>
        </div>
      </section>

      
      <section className="py-20 bg-background">
        <div className="container mx-auto px-4">
          <div className="space-y-8">
            {allCourses.map((course, i) => (
              <motion.div
                key={course.slug}
                id={course.slug}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.05 }}
                className="rounded-xl bg-card border border-border shadow-card overflow-hidden"
              >
                <div className="p-6 md:p-8">
                  <div className="flex flex-col md:flex-row gap-6">
                    <div className="flex-1">
                      <div className="flex items-center gap-3 mb-4">
                        <span className="text-4xl">{course.icon}</span>
                        <div>
                          <h2 className="font-heading text-2xl font-bold text-foreground">{course.name}</h2>
                          <p className="text-sm text-muted-foreground">{course.desc}</p>
                        </div>
                      </div>
                      <p className="text-foreground/80 mb-4">{course.details}</p>
                      <div className="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                        <div className="flex items-center gap-2 text-sm">
                          <Clock className="h-4 w-4 text-primary" />
                          <span className="text-muted-foreground">Duration: <strong className="text-foreground">{course.duration}</strong></span>
                        </div>
                        <div className="flex items-center gap-2 text-sm">
                          <DollarSign className="h-4 w-4 text-primary" />
                          <span className="text-muted-foreground">Fees: <strong className="text-foreground">{course.fees}</strong></span>
                        </div>
                        <div className="flex items-center gap-2 text-sm">
                          <Globe className="h-4 w-4 text-primary" />
                          <span className="text-muted-foreground text-xs">{course.countries}</span>
                        </div>
                      </div>
                    </div>
                    <div className="md:w-64 flex-shrink-0">
                      <div className="bg-muted rounded-lg p-4">
                        <h4 className="font-heading font-semibold text-foreground text-sm mb-3">Key Highlights</h4>
                        <ul className="space-y-2">
                          {course.highlights.map((h) => (
                            <li key={h} className="flex items-center gap-2 text-sm text-foreground/80">
                              <GraduationCap className="h-3.5 w-3.5 text-primary flex-shrink-0" />
                              {h}
                            </li>
                          ))}
                        </ul>
                      </div>
                      <Link to="/contact" className="block mt-4">
                        <Button className="w-full bg-primary text-primary-foreground hover:bg-primary-dark font-heading">
                          Apply Now <ArrowRight className="ml-2 h-4 w-4" />
                        </Button>
                      </Link>
                    </div>
                  </div>
                </div>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      <CounsellingCTA />
    </div>
  );
};

export default Courses;
