const API_BASE = '/backend/api.php';

async function apiFetch<T>(params: Record<string, string>): Promise<T | null> {
  
  const urls = [
    new URL(API_BASE, window.location.origin),
    new URL('api.php', 'http://127.0.0.1:8000') 
  ];

  for (const url of urls) {
    Object.entries(params).forEach(([k, v]) => url.searchParams.set(k, v));
    url.searchParams.set('_t', Date.now().toString());
    
    try {
      console.log(`[CMS] Fetching from: ${url.toString()}`);
      const res = await fetch(url.toString(), { credentials: 'include' });
      const text = await res.text();
      
      if (res.ok) {
        try {
          const data = JSON.parse(text);
          console.log(`[CMS] Success from ${url.host}!`);
          return data;
        } catch (e) {
          console.error(`[CMS Parse Error] from ${url.host}:`, text);
        }
      } else {
        console.warn(`[CMS API Warning] ${url.host} returned ${res.status}`);
      }
    } catch (err) {
      console.warn(`[CMS Network Error] Failed to reach ${url.host}`);
    }
  }
  return null;
}

export async function submitLead(data: Record<string, string>): Promise<{success?: boolean, error?: string, message?: string} | null> {
  const urls = [
    new URL('/backend/submit_lead.php', window.location.origin),
    new URL('submit_lead.php', 'http://127.0.0.1:8000')
  ];

  for (const url of urls) {
    try {
      const res = await fetch(url.toString(), {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
        credentials: 'include'
      });
      if (res.ok) {
        return await res.json();
      }
    } catch (err) {
      console.warn(`[CMS POST Error] Failed to reach ${url.host}`);
    }
  }
  return null;
}

export async function fetchContent(section: string): Promise<Record<string, string> | null> {
  return apiFetch({ action: 'content', section });
}

export async function fetchContentAll(sections: string[]): Promise<Record<string, Record<string, string>> | null> {
  return apiFetch({ action: 'content_all', sections: sections.join(',') });
}

export interface SiteImage {
  id: number;
  image_key: string;
  image_path: string;
  alt_text: string;
  label: string;
  sort_order: number;
}

export async function fetchImages(section: string): Promise<SiteImage[] | null> {
  return apiFetch({ action: 'images', section });
}

export interface Testimonial {
  id: number;
  name: string;
  course: string;
  text: string;
  rating: number;
}

export async function fetchTestimonials(): Promise<Testimonial[] | null> {
  return apiFetch({ action: 'testimonials' });
}

export interface BlogPost {
  id: number;
  title: string;
  excerpt: string;
  category: string;
  read_time: string;
  image_path: string;
  published_at: string;
}

export async function fetchBlogPosts(limit = 3): Promise<BlogPost[] | null> {
  return apiFetch({ action: 'blog', limit: String(limit) });
}

export interface University {
  id: number;
  country: string;
  rank: number;
  name: string;
  short_name: string;
  city: string;
  flag: string;
  rating: number;
  ranking_text: string;
  cutoff: string;
  deadline: string;
  fees: string;
}

export async function fetchUniversities(country?: string): Promise<University[] | Record<string, University[]> | null> {
  const params: Record<string, string> = { action: 'universities' };
  if (country) params.country = country;
  return apiFetch(params);
}

export async function fetchUniversityCountries(): Promise<string[] | null> {
  return apiFetch({ action: 'university_countries' });
}

export interface GalleryImage {
  id: number;
  image_path: string;
  alt_text: string;
}

export async function fetchGalleryImages(): Promise<GalleryImage[] | null> {
  return apiFetch({ action: 'gallery' });
}

export async function checkBackendHealth(): Promise<boolean> {
  const result = await apiFetch<{ status: string }>({ action: 'health' });
  return result?.status === 'ok';
}
