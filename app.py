from flask import Flask, request, jsonify

app = Flask(__name__)

# Predefined information about diabetes
diabetes_info = {
    "definition": "Diabetes is a chronic metabolic disorder characterized by high blood glucose levels due to insufficient insulin production, ineffective insulin use, or both.",
    "types": {
        "Type 1": "An autoimmune condition where the immune system destroys insulin-producing cells.",
        "Type 2": "The most common form, often linked to obesity, inactivity, and poor diet.",
        "Gestational": "Occurs during pregnancy.",
        "Prediabetes": "A precursor to Type 2 diabetes."
    },
    "risk_factors": "Risk factors vary by type but include genetics, obesity, sedentary lifestyles, and poor diet.",
    "symptoms": "Symptoms often include frequent urination, excessive thirst, hunger, fatigue, blurred vision, and slow-healing wounds.",
    "diagnosis": "Diagnosis is made through blood tests like fasting plasma glucose, oral glucose tolerance, HbA1c, and random plasma glucose tests.",
    "treatment": "Treatment depends on the type and may involve insulin therapy, oral or injectable medications, lifestyle changes, and regular blood sugar monitoring.",
    "complications": "Poorly managed diabetes can lead to acute complications and chronic issues such as cardiovascular disease.",
    "prevention": "Prevention focuses on maintaining a healthy weight, eating a balanced diet, and exercising regularly.",
    "management": "Living with diabetes requires education, support, and technology like continuous glucose monitors.",
    "research": "Advances in research offer hope for improved management and treatment in the future.",
    "conclusion": "With proper care, individuals with diabetes can lead healthy, fulfilling lives."
}

@app.route('/ask', methods=['POST'])
def ask():
    user_question = request.json.get("question").lower()
    answer = "I don't know the answer to that."

    if "definition" in user_question:
        answer = diabetes_info["definition"]
    elif "types" in user_question:
        answer = "Types of diabetes: " + ", ".join(diabetes_info["types"].keys())
    elif "type 1" in user_question:
        answer = diabetes_info["types"]["Type 1"]
    elif "type 2" in user_question:
        answer = diabetes_info["types"]["Type 2"]
    elif "gestational" in user_question:
        answer = diabetes_info["types"]["Gestational"]
    elif "prediabetes" in user_question:
        answer = diabetes_info["types"]["Prediabetes"]
    elif "risk factors" in user_question:
        answer = diabetes_info["risk_factors"]
    elif "symptoms" in user_question:
        answer = diabetes_info["symptoms"]
    elif "diagnosis" in user_question:
        answer = diabetes_info["diagnosis"]
    elif "treatment" in user_question:
        answer = diabetes_info["treatment"]
    elif "complications" in user_question:
        answer = diabetes_info["complications"]
    elif "prevention" in user_question:
        answer = diabetes_info["prevention"]
    elif "management" in user_question:
        answer = diabetes_info["management"]
    elif "research" in user_question:
        answer = diabetes_info["research"]
    elif "healthy lives" in user_question:
        answer = diabetes_info["conclusion"]

    return jsonify({"answer": answer})

if __name__ == '__main__':
    app.run(debug=True)