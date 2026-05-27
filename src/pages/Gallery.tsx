/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { useState, useEffect } from "react";
import { motion } from "framer-motion";
import CounsellingCTA from "@/components/CounsellingCTA";
import { fetchGalleryImages, type GalleryImage } from "@/lib/api";

const defaultGalleryItems = Array.from({ length: 39 }, (_, i) => ({
  id: i + 11,
  image_path: `/gallery/Untitled design (${i + 11}).png`,
  alt_text: `Gallery Image ${i + 11}`,
}));

const Gallery = () => {
  const [images, setImages] = useState<GalleryImage[]>(defaultGalleryItems);

  useEffect(() => {
    fetchGalleryImages().then((data) => {
      if (data && data.length > 0) setImages(data);
    });
  }, []);

  return (
    <div>
      <section className="gradient-hero py-20">
        <div className="container mx-auto px-4 text-center">
          <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }}>
            <h1 className="font-heading text-4xl md:text-5xl font-bold text-primary-foreground mb-4">Gallery</h1>
            <p className="text-primary-foreground/80 text-lg">Glimpses of our students' journey and campus life</p>
          </motion.div>
        </div>
      </section>

      <section className="py-20 bg-background">
        <div className="container mx-auto px-4">

          
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            {images.map((item, i) => (
              <motion.div
                key={item.id}
                initial={{ opacity: 0, scale: 0.9 }}
                whileInView={{ opacity: 1, scale: 1 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.03 }}
                className="aspect-square rounded-xl overflow-hidden relative group cursor-pointer border border-border"
              >
                <img
                  src={item.image_path}
                  alt={item.alt_text}
                  className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                  loading="lazy"
                />
                <div className="absolute inset-0 bg-foreground/0 group-hover:bg-foreground/20 transition-colors" />
              </motion.div>
            ))}
          </div>
        </div>
      </section>
      <CounsellingCTA />
    </div>
  );
};

export default Gallery;
