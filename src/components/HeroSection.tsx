/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { useState, useEffect, useCallback } from "react";
import { Link } from "react-router-dom";
import { motion, AnimatePresence } from "framer-motion";
import { Search, GraduationCap, Users, Globe, CheckCircle2, ChevronLeft, ChevronRight } from "lucide-react";
import { Button } from "@/components/ui/button";
import { fetchContent, fetchImages } from "@/lib/api";

const defaultSlides = [
  { src: "/clgs/slide-1.jpg", alt: "Students at a top university campus", label: "World-Class Universities" },
  { src: "/clgs/slide-2.jpg", alt: "Medical students in a lecture hall", label: "MBBS Abroad Programs" },
  { src: "/clgs/slide-3.jpg", alt: "University campus abroad", label: "NMC & WHO Approved" },
  { src: "/clgs/slide-4.jpg", alt: "Indian students studying abroad", label: "1,500+ Dreams Fulfilled" },
];

const defaultTags = ["Study Abroad Options", "MBBS Abroad", "Affordable Universities", "Book Free Counselling"];

const trustBadges = [
  { icon: GraduationCap, label: "NMC & WHO Approved" },
  { icon: Users, label: "1,500+ Dreams Fulfilled" },
  { icon: Globe, label: "40+ Countries" },
];

const AUTOPLAY_DELAY = 4000;

const HeroSection = () => {
  const [current, setCurrent] = useState(0);
  const [searchQuery, setSearchQuery] = useState("");
  const [isPaused, setIsPaused] = useState(false);
  const [slides, setSlides] = useState(defaultSlides);
  const [heroText, setHeroText] = useState<Record<string, string>>({});
  const [tags, setTags] = useState(defaultTags);
  useEffect(() => {
    fetchImages("hero_slides").then((imgs) => {
      if (imgs && imgs.length > 0) {
        setSlides(imgs.map((i) => ({ src: i.image_path, alt: i.alt_text, label: i.label || "" })));
      }
    });

    fetchContent("hero").then((data) => {
      if (data) {
        setHeroText(data);
        if (data.tags) {
          const filteredTags = data.tags.split(",")
            .map((t: string) => t.trim())
            .filter((tag: string) => tag.toLowerCase() !== 'study in russia');
          setTags(filteredTags);
        }
      }
    });
  }, []);

  const next = useCallback(() => {
    setCurrent((prev) => (prev + 1) % slides.length);
  }, [slides.length]);

  const prev = useCallback(() => {
    setCurrent((prev) => (prev - 1 + slides.length) % slides.length);
  }, [slides.length]);

  useEffect(() => {
    if (isPaused) return;
    const timer = setInterval(next, AUTOPLAY_DELAY);
    return () => clearInterval(timer);
  }, [next, isPaused]);

  return (
    <section
      className="relative w-full overflow-hidden"
      style={{ minHeight: "20vh" }}
      onMouseEnter={() => setIsPaused(true)}
      onMouseLeave={() => setIsPaused(false)}
    >
      <div className="absolute inset-0">
        <AnimatePresence initial={false}>
          <motion.img
            key={current}
            src={slides[current].src}
            alt={slides[current].alt}
            initial={{ opacity: 0, scale: 1.04 }}
            animate={{ opacity: 1, scale: 1 }}
            exit={{ opacity: 0, scale: 0.98 }}
            transition={{ duration: 0.9, ease: "easeInOut" }}
            className="absolute inset-0 w-full h-full object-cover"
          />
        </AnimatePresence>
        <div className="absolute inset-0 bg-gradient-to-r from-black/75 via-black/50 to-black/20" />
        <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent" />
      </div>

      <div className="relative z-10 container mx-auto px-4 sm:px-6 flex flex-col justify-center" style={{ minHeight: "20vh" }}>
        <div className="max-w-5xl py-2 md:py-4">
          <motion.div
            initial={{ opacity: 0, y: -10 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5, delay: 0.1 }}
            className="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 mb-6"
          >
            <CheckCircle2 className="h-4 w-4 text-green-400" />
            <span className="text-xs font-semibold text-white uppercase tracking-wider">
              {heroText.badge_text || "Trusted by parents, chosen by students worldwide."}
            </span>
          </motion.div>
          <motion.p
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.2 }}
            className="text-lg sm:text-xl md:text-2xl font-bold text-white mb-4 max-w-2xl leading-relaxed"
          >
            {(heroText.subtitle || "Opening doors to globally recognized universities worldwide").toUpperCase()}
          </motion.p>
          <motion.h1
            key={`heading-${current}`}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            className="font-heading text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-[1.1] tracking-tight"
          >
            {heroText.title_line1 || "Explore, Apply & Succeed in"}{" "}
            <span className="text-amber-400">{heroText.title_highlight || "Study Abroad & MBBS Abroad"}</span>
            <br />
            {heroText.title_line3 || "with Educationopedia"}
          </motion.h1>
          <motion.div
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.3 }}
            className="flex flex-col sm:flex-row gap-2 max-w-xl mt-7"
          >
            <div className="relative flex-1">
              <Search className="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
              <input
                type="text"
                placeholder="Search universities, courses, countries..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="w-full pl-10 pr-4 py-3.5 rounded-xl bg-white/95 text-gray-900 placeholder:text-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 shadow-lg"
              />
            </div>
            <Button className="bg-amber-500 hover:bg-amber-400 text-black font-heading font-bold px-7 rounded-xl uppercase tracking-wider text-sm shrink-0 shadow-lg shadow-amber-500/30 transition-all">
              Search
            </Button>
          </motion.div>
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.5, delay: 0.45 }}
            className="flex flex-wrap gap-2 mt-4"
          >
            {tags.map((tag) => (
              <span
                key={tag}
                className="text-xs sm:text-sm px-3 py-1.5 rounded-full border border-white/30 bg-white/10 backdrop-blur-sm text-white hover:bg-white/20 hover:border-white/50 transition-all cursor-default"
              >
                {tag}
              </span>
            ))}
          </motion.div>
          <motion.div
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.5 }}
            className="flex flex-wrap gap-3 mt-7"
          >
            <Link to="/universities">
              <Button
                size="lg"
                className="bg-amber-500 hover:bg-amber-400 text-black font-heading font-bold px-7 rounded-xl uppercase tracking-wider text-sm shadow-lg shadow-amber-500/30"
              >
                Explore Universities
              </Button>
            </Link>
            <Link to="/contact">
              <Button
                size="lg"
                variant="outline"
                className="border-2 border-white text-white hover:bg-white hover:text-gray-900 font-heading font-bold px-7 rounded-xl uppercase tracking-wider text-sm backdrop-blur-sm bg-white/10"
              >
                Book Free Counselling
              </Button>
            </Link>
          </motion.div>
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.6, delay: 0.65 }}
            className="flex flex-wrap gap-5 mt-8 pt-6 border-t border-white/20"
          >
            {trustBadges.map((badge) => (
              <div key={badge.label} className="flex items-center gap-2">
                <div className="h-8 w-8 rounded-full bg-white/15 backdrop-blur-sm flex items-center justify-center">
                  <badge.icon className="h-4 w-4 text-amber-400" />
                </div>
                <span className="text-xs sm:text-sm font-medium text-white/90">{badge.label}</span>
              </div>
            ))}
          </motion.div>
        </div>
      </div>
      <button
        onClick={prev}
        aria-label="Previous slide"
        className="absolute left-4 top-1/2 -translate-y-1/2 z-20 h-10 w-10 rounded-full bg-black/40 hover:bg-black/70 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white transition-all hover:scale-110"
      >
        <ChevronLeft className="h-5 w-5" />
      </button>
      <button
        onClick={next}
        aria-label="Next slide"
        className="absolute right-4 top-1/2 -translate-y-1/2 z-20 h-10 w-10 rounded-full bg-black/40 hover:bg-black/70 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white transition-all hover:scale-110"
      >
        <ChevronRight className="h-5 w-5" />
      </button>
      <div className="absolute bottom-6 right-6 z-20 flex flex-col items-end gap-2">
        <AnimatePresence mode="wait">
          <motion.div
            key={`label-${current}`}
            initial={{ opacity: 0, y: 6 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -6 }}
            transition={{ duration: 0.35 }}
            className="text-xs text-white/80 bg-black/40 backdrop-blur-sm border border-white/20 rounded-full px-3 py-1 font-medium"
          >
            {slides[current].label}
          </motion.div>
        </AnimatePresence>
        <div className="text-xs text-white/70 bg-black/40 backdrop-blur-sm border border-white/20 rounded-full px-3 py-1 font-medium tabular-nums">
          {current + 1} / {slides.length}
        </div>
      </div>
      <div className="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
        {slides.map((_, i) => (
          <button
            key={i}
            onClick={() => setCurrent(i)}
            aria-label={`Go to slide ${i + 1}`}
            className={`transition-all duration-300 rounded-full ${i === current
                ? "bg-amber-400 w-6 h-2"
                : "bg-white/50 hover:bg-white/80 w-2 h-2"
              }`}
          />
        ))}
      </div>
      <div className="absolute bottom-0 left-0 right-0 z-20 h-0.5 bg-white/10">
        <motion.div
          key={current}
          className="h-full bg-amber-400"
          initial={{ width: "0%" }}
          animate={{ width: "100%" }}
          transition={{ duration: AUTOPLAY_DELAY / 1000, ease: "linear" }}
        />
      </div>
    </section>
  );
};

export default HeroSection;
