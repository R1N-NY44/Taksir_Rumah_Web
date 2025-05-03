from flask import Flask, request, jsonify
import pickle
import numpy as np
from flask_cors import CORS
import xgboost as xgb
import os

app = Flask(__name__)
CORS(app)

# Base directory untuk akses relatif
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
MODELS_DIR = os.path.join(BASE_DIR, "models_scalers")

# Fungsi untuk load model dan scaler dengan path relatif
def load_pickle(filename):
    return pickle.load(open(os.path.join(MODELS_DIR, filename), "rb"))

# Load model dan scaler
models = {
    "jakarta": load_pickle("jkt_xgb.pkl"),
    "bandung": load_pickle("bdg_xgb.pkl"),
    "yogya": load_pickle("ygy_xgb.pkl"),
    "surabaya": load_pickle("sby_xgb.pkl"),
    "bali": load_pickle("bali_xgb.pkl")
}

scalers = {
    "jakarta": {
        "robust": load_pickle("jkt_robust.pkl"),
        "minmax": load_pickle("jkt_minmax.pkl")
    },
    "bandung": {
        "robust": load_pickle("bdg_robust.pkl"),
        "minmax": load_pickle("bdg_minmax.pkl")
    },
    "yogya": {
        "robust": load_pickle("ygy_robust.pkl"),
        "minmax": load_pickle("ygy_minmax.pkl")
    },
    "surabaya": {
        "robust": load_pickle("sby_robust.pkl"),
        "minmax": load_pickle("sby_minmax.pkl")
    },
    "bali": {
        "robust": load_pickle("bali_robust.pkl"),
        "minmax": load_pickle("bali_minmax.pkl")
    }
}

@app.route("/predict", methods=["POST"])
def predict():
    data = request.get_json()

    region = data.get("region")
    if region not in models:
        return jsonify({"error": "Unsupported region"}), 400

    model = models[region]
    robust_scaler = scalers[region]["robust"]
    minmax_scaler = scalers[region]["minmax"]

    try:
        # Raw inputs
        luas_tanah = float(data["luas_tanah"])
        luas_bangunan = float(data["luas_bangunan"])
        kamar_tidur = int(data["kamar_tidur"])
        kamar_mandi = int(data["kamar_mandi"])
        jumlah_lantai = int(data["jumlah_lantai"])
    except KeyError as e:
        return jsonify({"error": f"Missing input field: {e}"}), 400
    except ValueError:
        return jsonify({"error": "Invalid input types"}), 400

    # Split dan scale fitur
    robust_scaled = robust_scaler.transform([[luas_tanah, luas_bangunan]])[0]
    minmax_scaled = minmax_scaler.transform([[kamar_tidur, kamar_mandi, jumlah_lantai]])[0]

    # Gabungkan fitur
    full_features = list(robust_scaled) + list(minmax_scaled)

    # Prediksi
    pred_log = model.predict([full_features])[0]
    pred_price = np.expm1(pred_log)  # log1p inverse

    return jsonify({
        "region": region,
        "predicted_price": round(pred_price)
    })

if __name__ == "__main__":
    app.run(debug=True, host="0.0.0.0", port=8111)
    # app.run(debug=True, host="0.0.0.0", port=5000)
