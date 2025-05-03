<!-- Install first if it's not avaibel in server
sudo apt install python3-venv

python3 -m venv venv
source venv/bin/activate

pip install -r requirements.txt -->


<div align="center" style="margin-bottom: 2rem;">
  <a href="https://count.getloli.com" target="_blank">
    <img alt="Moe Counter!" src="https://count.getloli.com/@taksir-rumah?name=taksir-rumah&theme=rule34&padding=7&offset=0&align=center&scale=1.5&pixelated=1&darkmode=auto">
  </a>
</div>

# 🏠 Website Taksir Rumah

Sebuah website sederhana untuk memprediksi harga rumah berdasarkan data input menggunakan model Machine Learning yang telah dilatih sebelumnya. Dibuat sebagai bagian dari backend untuk aplikasi **Taksir Rumah**.

---

## 📁 Struktur Folder


```Taksir_Rumah_Web/
┣ Taksir_Rumah/
┃ ┣ app/
┃ ┣ bootstrap/
┃ ┣ config/
┃ ┣ database/
┃ ┣ public/
┃ ┣ resources/
┃ ┣ routes/
┃ ┣ storage/
┃ ┣ tests/
┃ ┣ vendor/
┃ ┣ .editorconfig
┃ ┣ .env
┃ ┣ .env.example
┃ ┣ .gitattributes
┃ ┣ .gitignore
┃ ┣ README.md
┃ ┣ artisan
┃ ┣ composer.json
┃ ┣ composer.lock
┃ ┣ package.json
┃ ┣ phpunit.xml
┃ ┗ vite.config.js
┣ api/
┃ ┣ models_scalers/
┃ ┣ venv/
┃ ┣ app-old.py
┃ ┣ app.py
┃ ┗ requirements.txt
┗ setup.md
```
##

## 📖 Installasi

<details>
  <summary>
    <strong>💻 Venv Setup (Python Virtual Environment)</strong>
  </summary>

Membuat vitual environment untuk flask api
```bash
# Installing venv (skip alr avaible on serv/client)
sudo apt install python3-venv

# Create a virtual environment
python3 -m venv venv
```
</details> 

##

<details>

  <summary>
    <strong>🗝️ Activate venv</strong>
  </summary>

```bash
# Activate the virtual environment (Windows)
.\venv\Scripts\activate

# For macOS/Linux:
bash
source venv/bin/activate
```
</details> 

##

<details>
  <summary>
    <strong>📦 API Library Setup</strong>
  </summary>

```bash
# Start Venv & change dir to this
cd api

# Installing the dependency
pip install -r requirements.txt
```
</details> 

## 

## ⚙️ Running Script

*Jakankan ke-2 promp ini pada terminal terpisah

<details>
  <summary>
    <strong>🖼️ Running Laravel (frontend)</strong>
  </summary>

```bash
# Migrate database
php artisan migrate

#running laravel
php artisan serve
```
</details> 

##

<details>
  <summary>
    <strong>📔 Running Flask API (backend)</strong>
  </summary>

masuk ke dalam venv terlebih dahulu (Instalasi > `🗝️ Activate venv`)

```bash
# Menjalankan backend
python app.py
```
</details> 

