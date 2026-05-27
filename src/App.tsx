/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Route, Routes, useLocation } from "react-router-dom";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { Toaster } from "@/components/ui/toaster";
import { TooltipProvider } from "@/components/ui/tooltip";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import WhatsAppButton from "@/components/WhatsAppButton";
import ScrollToTop from "@/components/ScrollToTop";
import Index from "./pages/Index";
import Courses from "./pages/Courses";
import Countries from "./pages/Countries";
import Universities from "./pages/Universities";
import About from "./pages/About";
import Contact from "./pages/Contact";
import Blog from "./pages/Blog";
import Gallery from "./pages/Gallery";
import NotFound from "./pages/NotFound";
import ScholarshipExam from "./pages/ScholarshipExam";
import ExamLogin from "./pages/ExamLogin";
import ExamPortal from "./pages/ExamPortal";
import LandingAds from "./pages/LandingAds";
import StudyAbroad from "./pages/StudyAbroad";

const queryClient = new QueryClient();

const AppContent = () => {
  const location = useLocation();
  const isLandingAds = location.pathname === "/landingads";

  return (
    <>
      {!isLandingAds && <Navbar />}
      <main className="min-h-screen">
        <Routes>
          <Route path="/" element={<Index />} />
          <Route path="/courses" element={<Courses />} />
          <Route path="/courses/:courseSlug" element={<Courses />} />
          <Route path="/countries" element={<Countries />} />
          <Route path="/countries/:countrySlug" element={<Countries />} />
          <Route path="/universities" element={<Universities />} />
          <Route path="/about" element={<About />} />
          <Route path="/study-abroad" element={<StudyAbroad />} />
          <Route path="/contact" element={<Contact />} />
          <Route path="/blog" element={<Blog />} />
          <Route path="/blog/:postId" element={<Blog />} />
          <Route path="/gallery" element={<Gallery />} />
          <Route path="/scholarship" element={<ScholarshipExam />} />
          <Route path="/exam/login" element={<ExamLogin />} />
          <Route path="/exam/portal" element={<ExamPortal />} />
          <Route path="/landingads" element={<LandingAds />} />
          <Route path="*" element={<NotFound />} />
        </Routes>
      </main>
      {!isLandingAds && <Footer />}
      {!isLandingAds && <WhatsAppButton />}
    </>
  );
};

const App = () => (
  <QueryClientProvider client={queryClient}>
    <TooltipProvider>
      <Toaster />
      <Sonner />
      <BrowserRouter>
        <ScrollToTop />
        <AppContent />
      </BrowserRouter>
    </TooltipProvider>
  </QueryClientProvider>
);

export default App;
