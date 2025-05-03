from flask import Flask, request, jsonify
import pickle
import numpy as np
from flask_cors import CORS
import xgboost as xgb  # Needed for .predict()

app = Flask(__name__)
CORS(app)


# Load model and scalers
models = {
    "jakarta": pickle.load(open("D:/TaksirRumah/api/models_scalers/jkt_xgb.pkl", "rb")),
    "bandung": pickle.load(open("D:/TaksirRumah/api/models_scalers/bdg_xgb.pkl", "rb")),
    "yogya": pickle.load(open("D:/TaksirRumah/api/models_scalers/ygy_xgb.pkl", "rb")),
    "surabaya": pickle.load(open("D:/TaksirRumah/api/models_scalers/sby_xgb.pkl", "rb")),
    "bali": pickle.load(open("D:/TaksirRumah/api/models_scalers/bali_xgb.pkl", "rb"))
}

scalers = {
    "jakarta": {
        "robust": pickle.load(open("D:/TaksirRumah/api/models_scalers/jkt_robust.pkl", "rb")),
        "minmax": pickle.load(open("D:/TaksirRumah/api/models_scalers/jkt_minmax.pkl", "rb"))
    },
    "bandung": {
        "robust": pickle.load(open("D:/TaksirRumah/api/models_scalers/bdg_robust.pkl", "rb")),
        "minmax": pickle.load(open("D:/TaksirRumah/api/models_scalers/bdg_minmax.pkl", "rb"))
    },
    "yogya": {
        "robust": pickle.load(open("D:/TaksirRumah/api/models_scalers/ygy_robust.pkl", "rb")),
        "minmax": pickle.load(open("D:/TaksirRumah/api/models_scalers/ygy_minmax.pkl", "rb"))
    },
    "surabaya": {
        "robust": pickle.load(open("D:/TaksirRumah/api/models_scalers/sby_robust.pkl", "rb")),
        "minmax": pickle.load(open("D:/TaksirRumah/api/models_scalers/sby_minmax.pkl", "rb"))
    },
    "bali": {
        "robust": pickle.load(open("D:/TaksirRumah/api/models_scalers/bali_robust.pkl", "rb")),
        "minmax": pickle.load(open("D:/TaksirRumah/api/models_scalers/bali_minmax.pkl", "rb"))
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

    # Split and scale features
    robust_scaled = robust_scaler.transform([[luas_tanah, luas_bangunan]])[0]
    minmax_scaled = minmax_scaler.transform([[kamar_tidur, kamar_mandi, jumlah_lantai]])[0]

    # Combine features for prediction
    full_features = list(robust_scaled) + list(minmax_scaled)

    # Predict
    pred_log = model.predict([full_features])[0]
    pred_price = np.expm1(pred_log)  # Convert back from log1p

    return jsonify({
        "region": region,
        "predicted_price": round(pred_price)
    })

if __name__ == "__main__":
    app.run(debug=True)