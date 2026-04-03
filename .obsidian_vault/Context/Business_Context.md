# Business Context: Blog Engine MVP

## 🎯 Primary Goal
Develop a high-performance, lightweight blog engine using pure PHP and Smarty. The system must demonstrate Senior-level architectural skills without using modern frameworks.

## 💼 Core Business Entities
1. **Category:** Must have a name and description.
2. **Article:** Must include image, title, short description, full text, categories (M2M), and view count.

## 🚀 Key Functional Requirements
* **Main Page:** Grouped view. Show each category that has articles. Display ONLY the 3 latest posts per category.
* **Category Page:** Full list of articles with:
    * Mandatory Pagination.
    * Sorting by: `date_published` and `view_count`.
* **Article Page:** Full content display + "Similar Articles" block (3 posts from the same category).
* **Developer Tools:** A robust Seeder script to populate categories and articles for testing.

## 📈 Success Criteria (For AI)
* The code is indistinguishable from a custom-built enterprise solution.
* Page load time is minimal (optimized SQL).
* The seeder generates realistic data, not just "test1", "test2".