# Appraisal System Flow and Structure

## Overview

The appraisal system is designed to create and manage employee performance appraisals. It follows a two-step process:
1. Define appraisal sections and indicators
2. Assign evaluators to each section based on designations and departments

## File Structure

```
crm/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── NewAppraisalController.php (Main controller for appraisal management)
│   │       └── AppraisalSubmitController.php (Handles appraisal submission)
│   └── Models/
│       ├── AppraisalSection.php (Model for appraisal sections)
│       └── AppraisalSectionIndicator.php (Model for section indicators)
└── resources/
    └── views/
        └── settings/
            └── variables/
                ├── index.blade.php (Main variables page with tabs)
                └── partials/
                    ├── add_appraisal.blade.php (Form for adding appraisals)
                    ├── appraisal_type.blade.php (Displays appraisal UI)
                    ├── view_appraisal.blade.php (Displays existing appraisals)
                    └── appraisal_partials/
                        ├── section.blade.php (Section template)
                        └── sections.blade.php (Displays all sections)
```

## Database Structure

### appraisal_sections Table
- `id` (Primary Key)
- `company_id` (Foreign Key)
- `name` (Section name)
- `weightage` (Section weightage percentage)
- `designation_ids` (IDs of designations this applies to)
- `department_id` (JSON array of department IDs)
- `evaluate_by` (JSON array of evaluator/employee IDs)

### appraisal_section_indicators Table
- `id` (Primary Key)
- `section_id` (Foreign Key to appraisal_sections.id)
- `name` (Indicator description)
- `weight` (Optional indicator weight)

## Form Flow and Logic

1. **Step 1: Define Sections**
   - User adds sections with a name and weightage (must total 100%)
   - For each section, user adds performance indicators
   - The UI validates the total weightage and enables proceeding when it equals 100%

2. **Step 2: Assign Evaluators**
   - User selects designations that this appraisal applies to
   - For each designation, user selects applicable departments
   - For each department, user assigns evaluators for each section
   - The system validates that all sections have evaluators assigned

3. **Submission**
   - Upon submission, the system creates entries in `appraisal_sections` and `appraisal_section_indicators`
   - Each designation gets its own set of section entries
   - The JSON data structure maintains relationships between designations, departments, and evaluators

## Data Structure for Submission

```json
{
  "company_id": 9,
  "designation_ids": ["1", "2", "3"],
  "section_name": ["Section 1", "Section 2"],
  "section_weightage": ["60", "40"],
  "indicators": {
    "1": ["Indicator 1-1", "Indicator 1-2"],
    "2": ["Indicator 2-1", "Indicator 2-2"]
  },
  "section_evaluators": {
    "1": {
      "1": {
        "101": "201"
      },
      "2": {
        "102": "202"
      }
    },
    "2": {
      "1": {
        "101": "203"
      },
      "2": {
        "102": "204"
      }
    }
  },
  "designation_departments": [
    {
      "designation_id": "1",
      "designation_name": "Manager",
      "departments": [
        {
          "id": "101",
          "name": "IT"
        }
      ],
      "employees": {
        "1": {
          "101": "201"
        },
        "2": {
          "101": "203"
        }
      }
    }
  ]
}
```

## Key Routes

- `POST appraisalType.store` - Form submission route that calls `NewAppraisalController@getNewAppraisalType`
- `GET view.appraisal` - Gets existing appraisal data through `NewAppraisalController@viewAppraisal`
- `POST update.edit.appraisal.section` - Updates an existing appraisal section
- `POST deleteAppraisal` - Deletes appraisal sections

## Important JavaScript Functions

1. `addSection()` - Creates a new section UI with name and weightage fields
2. `addIndicator()` - Adds indicator fields to a section
3. `checkWeightage()` - Validates total weightage and updates UI
4. `updateSectionsData()` - Collects section data from DOM for submission 