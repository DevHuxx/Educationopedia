/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { MessageCircle } from "lucide-react";

const WhatsAppButton = () => {
  if (window.location.pathname === "/exam/portal") return null;
  return (
    <a
      href="https://wa.me/918591342044?text=Hi%20Educationopedia!%20I%20need%20guidance%20for%20studying%20MBBS%20abroad."
      target="_blank"
      rel="noopener noreferrer"
      className="fixed bottom-6 right-6 z-50 flex items-center gap-2 bg-[#25D366] text-primary-foreground px-4 py-3 rounded-full shadow-elevated hover:scale-105 transition-transform"
      aria-label="Chat on WhatsApp"
    >
      <MessageCircle className="h-6 w-6" />
      <span className="hidden sm:inline font-heading font-semibold text-sm">Chat with us</span>
    </a>
  );
};

export default WhatsAppButton;
