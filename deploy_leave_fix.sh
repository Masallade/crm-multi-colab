#!/bin/bash

# Leave System Fix - Deployment Script
# This script helps deploy the leave balance fix to the server

echo "=========================================="
echo "Leave System Fix - Deployment Script"
echo "=========================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: artisan file not found. Please run this script from the Laravel root directory.${NC}"
    exit 1
fi

echo -e "${YELLOW}Step 1: Creating backups...${NC}"
mkdir -p backups/leave_fix_$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="backups/leave_fix_$(date +%Y%m%d_%H%M%S)"

# Backup files
cp app/Http/Controllers/EmployeeLeaveTypeDetailController.php "$BACKUP_DIR/" 2>/dev/null
cp app/Http/Controllers/Variables/EmployeeaddLeaveController.php "$BACKUP_DIR/" 2>/dev/null

echo -e "${GREEN}✓ Backups created in $BACKUP_DIR${NC}"
echo ""

echo -e "${YELLOW}Step 2: Verifying modified files exist...${NC}"
FILES_TO_CHECK=(
    "app/Http/Controllers/EmployeeLeaveTypeDetailController.php"
    "app/Http/Controllers/Variables/EmployeeaddLeaveController.php"
    "app/Console/Commands/DiagnoseLeaveData.php"
    "app/Console/Commands/RecalculateLeaveBalances.php"
)

MISSING_FILES=0
for file in "${FILES_TO_CHECK[@]}"; do
    if [ -f "$file" ]; then
        echo -e "${GREEN}✓ $file${NC}"
    else
        echo -e "${RED}✗ $file (MISSING)${NC}"
        MISSING_FILES=$((MISSING_FILES + 1))
    fi
done

if [ $MISSING_FILES -gt 0 ]; then
    echo -e "${RED}Error: $MISSING_FILES file(s) missing. Please ensure all files are uploaded.${NC}"
    exit 1
fi
echo ""

echo -e "${YELLOW}Step 3: Clearing cache...${NC}"
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
echo -e "${GREEN}✓ Cache cleared${NC}"
echo ""

echo -e "${YELLOW}Step 4: Running diagnostics...${NC}"
echo "Checking for leave data inconsistencies..."
php artisan leave:diagnose
echo ""

echo -e "${YELLOW}Step 5: Would you like to recalculate leave balances? (y/n)${NC}"
read -r response
if [[ "$response" =~ ^([yY][eE][sS]|[yY])$ ]]; then
    echo "Running dry-run first..."
    php artisan leave:recalculate --dry-run
    echo ""
    echo -e "${YELLOW}Apply these changes? (y/n)${NC}"
    read -r apply
    if [[ "$apply" =~ ^([yY][eE][sS]|[yY])$ ]]; then
        php artisan leave:recalculate
        echo -e "${GREEN}✓ Leave balances recalculated${NC}"
    else
        echo "Skipped recalculation."
    fi
else
    echo "Skipped recalculation."
fi
echo ""

echo -e "${GREEN}=========================================="
echo "Deployment Complete!"
echo "==========================================${NC}"
echo ""
echo "Next steps:"
echo "1. Test the leave application form"
echo "2. Test the Add Employee Leave page"
echo "3. Verify leave balances display correctly"
echo ""
echo "Backup location: $BACKUP_DIR"
echo ""
