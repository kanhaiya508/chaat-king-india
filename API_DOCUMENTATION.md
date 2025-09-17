# Restaurant Management System API Documentation

## Base URL
```
https://tabletray.ansdesk.com/api
```

## Authentication
This API uses Laravel Sanctum for authentication. All protected endpoints require a Bearer token in the Authorization header.

## Authentication Flow

### 1. Waiter Login
**Endpoint:** `POST /waiter/login`

**Request Body:**
```json
{
    "email": "admin@gmail.com",
    "password": "123456"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Waiter",
            "email": "admin@gmail.com"
        },
        "branches": [
            {
                "id": 1,
                "name": "Main Branch",
                "address": "123 Main St"
            }
        ],
        "token": "1|abc123...",
        "needs_branch_selection": false
    }
}
```

### 2. Branch Selection (if multiple branches)
**Endpoint:** `POST /waiter/select-branch`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "branch_id": 1
}
```

**Response:**
```json
{
    "success": true,
    "message": "Branch selected successfully",
    "data": {
        "selected_branch": {
            "id": 1,
            "name": "Main Branch",
            "address": "123 Main St"
        },
        "user": {
            "id": 1,
            "name": "John Waiter",
            "email": "admin@gmail.com"
        }
    }
}
```

### 3. Get Current User Info
**Endpoint:** `GET /waiter/me`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "name": "John Waiter",
            "email": "admin@gmail.com"
        },
        "current_branch": {
            "id": 1,
            "name": "Main Branch",
            "address": "123 Main St"
        },
        "branches": [
            {
                "id": 1,
                "name": "Main Branch",
                "address": "123 Main St"
            }
        ]
    }
}
```

### 4. Get Complete Profile Information
**Endpoint:** `GET /waiter/profile`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "Profile retrieved successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Waiter",
            "email": "admin@gmail.com",
            "waiter_app_access": true,
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        },
        "current_branch": {
            "id": 1,
            "name": "Main Branch",
            "address": "123 Main St",
            "phone": "+1234567890",
            "email": "main@restaurant.com",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        },
        "branches": [
            {
                "id": 1,
                "name": "Main Branch",
                "address": "123 Main St",
                "phone": "+1234567890",
                "email": "main@restaurant.com",
                "is_current": true,
                "created_at": "2024-01-01T00:00:00.000000Z",
                "updated_at": "2024-01-01T00:00:00.000000Z"
            },
            {
                "id": 2,
                "name": "Branch 2",
                "address": "456 Second St",
                "phone": "+1234567891",
                "email": "branch2@restaurant.com",
                "is_current": false,
                "created_at": "2024-01-01T00:00:00.000000Z",
                "updated_at": "2024-01-01T00:00:00.000000Z"
            }
        ],
        "total_branches": 2,
        "has_multiple_branches": true,
        "branch_selection_required": false
    }
}
```

### 4. Logout
**Endpoint:** `POST /waiter/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "Logged out successfully"
}
```

### 5. Update Profile
**Endpoint:** `PUT /waiter/profile`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body (both fields are optional):**
```json
{
    "name": "Updated Name",
    "email": "newemail@gmail.com"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Profile updated successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "Updated Name",
            "email": "newemail@gmail.com",
            "waiter_app_access": true,
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T12:00:00.000000Z"
        },
        "current_branch": {
            "id": 1,
            "name": "Main Branch",
            "address": "123 Main St",
            "phone": "+1234567890",
            "email": "main@restaurant.com",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        },
        "branches": [
            {
                "id": 1,
                "name": "Main Branch",
                "address": "123 Main St",
                "phone": "+1234567890",
                "email": "main@restaurant.com",
                "is_current": true,
                "created_at": "2024-01-01T00:00:00.000000Z",
                "updated_at": "2024-01-01T00:00:00.000000Z"
            }
        ],
        "total_branches": 1,
        "has_multiple_branches": false,
        "branch_selection_required": false
    }
}
```

## Protected Endpoints

All endpoints below require authentication headers:
```
Authorization: Bearer {token}
```

## Table Categories API

### Get All Table Categories
**Endpoint:** `GET /tablecategories`

**Response:**
```json
{
    "success": true,
    "message": "Table categories retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "VIP Tables",
            "branch_id": 1,
            "branch": {
                "id": 1,
                "name": "Main Branch"
            },
            "tables": [
                {
                    "id": 1,
                    "name": "VIP-01",
                    "tablecategory_id": 1
                }
            ]
        }
    ]
}
```

### Get Single Table Category
**Endpoint:** `GET /tablecategories/{id}`

**Response:**
```json
{
    "success": true,
    "message": "Table category retrieved successfully",
    "data": {
        "id": 1,
        "name": "VIP Tables",
        "branch_id": 1,
        "branch": {
            "id": 1,
            "name": "Main Branch"
        },
        "tables": [
            {
                "id": 1,
                "name": "VIP-01",
                "tablecategory_id": 1
            }
        ]
    }
}
```

## Tables API with Status

### Get All Tables with Categories and Status
**Endpoint:** `GET /tables`

**Response:**
```json
{
    "success": true,
    "message": "Tables with status retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "VIP Tables",
            "branch_id": 1,
            "tables": [
                {
                    "id": 1,
                    "name": "VIP-01",
                    "tablecategory_id": 1,
                    "branch_id": 1,
                    "status": "occupied",
                    "status_label": "Occupied",
                    "status_class": "bg-danger text-white",
                    "last_order": {
                        "id": 15,
                        "status": "occupied",
                        "is_paid": false,
                        "created_at": "2024-01-01T10:30:00.000000Z",
                        "updated_at": "2024-01-01T10:30:00.000000Z",
                        "items": [
                            {
                                "id": 1,
                                "item_id": 5,
                                "item_name": "Chicken Wings",
                                "quantity": 2,
                                "price": 5.99,
                                "total_price": 11.98
                            },
                            {
                                "id": 2,
                                "item_id": 8,
                                "item_name": "French Fries",
                                "quantity": 1,
                                "price": 3.99,
                                "total_price": 3.99
                            }
                        ]
                    }
                },
                {
                    "id": 2,
                    "name": "VIP-02",
                    "tablecategory_id": 1,
                    "branch_id": 1,
                    "status": "available",
                    "status_label": "Available",
                    "status_class": "bg-light text-dark",
                    "last_order": null
                }
            ]
        },
        {
            "id": 2,
            "name": "Regular Tables",
            "branch_id": 1,
            "tables": [
                {
                    "id": 3,
                    "name": "R-01",
                    "tablecategory_id": 2,
                    "branch_id": 1,
                    "status": "saved",
                    "status_label": "Saved",
                    "status_class": "bg-success text-dark",
                    "last_order": {
                        "id": 16,
                        "status": "saved",
                        "created_at": "2024-01-01T11:00:00.000000Z",
                        "updated_at": "2024-01-01T11:00:00.000000Z"
                    }
                }
            ]
        }
    ]
}
```

### Get Single Table with Status
**Endpoint:** `GET /tables/{id}`

**Response:**
```json
{
    "success": true,
    "message": "Table with status retrieved successfully",
    "data": {
        "id": 1,
        "name": "VIP-01",
        "tablecategory_id": 1,
        "branch_id": 1,
        "tablecategory": {
            "id": 1,
            "name": "VIP Tables"
        },
        "status": "occupied",
        "status_label": "Occupied",
        "status_class": "bg-danger text-white",
        "last_order": {
            "id": 15,
            "status": "occupied",
            "is_paid": false,
            "created_at": "2024-01-01T10:30:00.000000Z",
            "updated_at": "2024-01-01T10:30:00.000000Z",
            "items": [
                {
                    "id": 1,
                    "item_id": 5,
                    "item_name": "Chicken Wings",
                    "quantity": 2,
                    "price": 5.99,
                    "total_price": 11.98
                },
                {
                    "id": 2,
                    "item_id": 8,
                    "item_name": "French Fries",
                    "quantity": 1,
                    "price": 3.99,
                    "total_price": 3.99
                }
            ]
        }
    }
}
```

### Table Status Types
The API returns different status types with their corresponding labels and CSS classes:

| Status | Label | CSS Class | Description |
|--------|-------|-----------|-------------|
| `available` | Available | `bg-light text-dark` | Table is free |
| `occupied` | Occupied | `bg-danger text-white` | Table has active order |
| `saved` | Saved | `bg-success text-dark` | Order saved but not printed |
| `saved_and_printed` | Saved & Printed | `bg-danger text-white` | Order saved and printed |
| `saved_and_billed` | Saved & Billed | `bg-primary text-white` | Order saved and billed |
| `kot` | KOT | `bg-success text-white` | Kitchen Order Ticket generated |
| `kot_print` | KOT Printed | `bg-teal text-white` | KOT printed |
| `hold` | Hold | `bg-secondary text-white` | Order on hold |

### Order Items Information
- **Items are included** only when `is_paid` is `false`
- **Items are null** when `is_paid` is `true` (order is paid)
- Each item includes:
  - `id`: Order item ID
  - `item_id`: Original item ID
  - `item_name`: Item name
  - `quantity`: Quantity ordered
  - `price`: Unit price
  - `total_price`: Total price for this item

## Categories API

### Get All Categories
**Endpoint:** `GET /categories`

**Response:**
```json
{
    "success": true,
    "message": "Categories retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Appetizers",
            "user_id": 1,
            "branch_id": 1,
            "branch": {
                "id": 1,
                "name": "Main Branch"
            },
            "user": {
                "id": 1,
                "name": "Admin User"
            },
            "items": [
                {
                    "id": 1,
                    "name": "Chicken Wings",
                    "category_id": 1,
                    "type": "piece",
                    "is_available": true
                }
            ]
        }
    ]
}
```

### Get Single Category
**Endpoint:** `GET /categories/{id}`

**Response:**
```json
{
    "success": true,
    "message": "Category retrieved successfully",
    "data": {
        "id": 1,
        "name": "Appetizers",
        "user_id": 1,
        "branch_id": 1,
        "branch": {
            "id": 1,
            "name": "Main Branch"
        },
        "user": {
            "id": 1,
            "name": "Admin User"
        },
        "items": [
            {
                "id": 1,
                "name": "Chicken Wings",
                "category_id": 1,
                "type": "piece",
                "is_available": true
            }
        ]
    }
}
```

### Get Items by Category
**Endpoint:** `GET /categories/{categoryId}/items`

**Response:**
```json
{
    "success": true,
    "message": "Items retrieved by category successfully",
    "data": [
        {
            "id": 1,
            "name": "Chicken Wings",
            "category_id": 1,
            "type": "piece",
            "is_available": true,
            "branch_id": 1,
            "user_id": 1,
            "variants": [
                {
                    "id": 1,
                    "name": "Small",
                    "price": 5.99,
                    "item_id": 1
                }
            ],
            "addons": [
                {
                    "id": 1,
                    "name": "Extra Sauce",
                    "price": 1.50,
                    "item_id": 1
                }
            ]
        }
    ]
}
```

## Items API

### Get All Items
**Endpoint:** `GET /items`

**Response:**
```json
{
    "success": true,
    "message": "Items retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Chicken Wings",
            "category_id": 1,
            "type": "piece",
            "is_available": true,
            "branch_id": 1,
            "user_id": 1,
            "branch": {
                "id": 1,
                "name": "Main Branch"
            },
            "user": {
                "id": 1,
                "name": "Admin User"
            },
            "category": {
                "id": 1,
                "name": "Appetizers"
            },
            "variants": [
                {
                    "id": 1,
                    "name": "Small",
                    "price": 5.99,
                    "item_id": 1
                },
                {
                    "id": 2,
                    "name": "Large",
                    "price": 8.99,
                    "item_id": 1
                }
            ],
            "addons": [
                {
                    "id": 1,
                    "name": "Extra Sauce",
                    "price": 1.50,
                    "item_id": 1
                }
            ]
        }
    ]
}
```

### Get Single Item
**Endpoint:** `GET /items/{id}`

**Response:**
```json
{
    "success": true,
    "message": "Item retrieved successfully",
    "data": {
        "id": 1,
        "name": "Chicken Wings",
        "category_id": 1,
        "type": "piece",
        "is_available": true,
        "branch_id": 1,
        "user_id": 1,
        "branch": {
            "id": 1,
            "name": "Main Branch"
        },
        "user": {
            "id": 1,
            "name": "Admin User"
        },
        "category": {
            "id": 1,
            "name": "Appetizers"
        },
        "variants": [
            {
                "id": 1,
                "name": "Small",
                "price": 5.99,
                "item_id": 1
            }
        ],
        "addons": [
            {
                "id": 1,
                "name": "Extra Sauce",
                "price": 1.50,
                "item_id": 1
            }
        ]
    }
}
```

### Get Items by Category
**Endpoint:** `GET /items/category/{categoryId}`

**Response:** Same as "Get All Items" but filtered by category.

### Get Available Items Only
**Endpoint:** `GET /items/available`

**Response:** Same as "Get All Items" but only items where `is_available` is `true`.

### Get Items by Type
**Endpoint:** `GET /items/type/{type}`

**Valid Types:** `size`, `piece`, `weight`, `flavour`, `combo`, `half`

**Response:** Same as "Get All Items" but filtered by type.

## Error Responses

### Authentication Error (401)
```json
{
    "success": false,
    "message": "Invalid credentials or no waiter access"
}
```

### Validation Error (422)
```json
{
    "success": false,
    "message": "Validation error",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password field is required."]
    }
}
```

### Not Found Error (404)
```json
{
    "success": false,
    "message": "Item not found or not accessible"
}
```

### Branch Selection Error (400)
```json
{
    "success": false,
    "message": "Please select a branch first"
}
```

### Access Denied Error (403)
```json
{
    "success": false,
    "message": "Access denied. Waiter app access required."
}
```

### Validation Error for Update Profile (422)
```json
{
    "success": false,
    "message": "Validation error",
    "errors": {
        "email": ["The email has already been taken."],
        "name": ["The name field is required."]
    }
}
```

### No Fields Provided Error (400)
```json
{
    "success": false,
    "message": "No valid fields provided for update"
}
```

## Flutter Integration Examples

### HTTP Client Setup
```dart
import 'package:http/http.dart' as http;
import 'dart:convert';

class ApiService {
  static const String baseUrl = 'https://tabletray.ansdesk.com/api';
  String? _token;
  
  void setToken(String token) {
    _token = token;
  }
  
  Map<String, String> get _headers {
    Map<String, String> headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };
    
    if (_token != null) {
      headers['Authorization'] = 'Bearer $_token';
    }
    
    return headers;
  }
}
```

### Login Function
```dart
Future<Map<String, dynamic>> login(String email, String password) async {
  final response = await http.post(
    Uri.parse('${ApiService.baseUrl}/waiter/login'),
    headers: _headers,
    body: jsonEncode({
      'email': email,
      'password': password,
    }),
  );
  
  if (response.statusCode == 200) {
    final data = jsonDecode(response.body);
    if (data['success']) {
      _token = data['data']['token'];
      return data['data'];
    }
  }
  
  throw Exception('Login failed');
}
```

### Get Items Function
```dart
Future<List<dynamic>> getItems() async {
  final response = await http.get(
    Uri.parse('${ApiService.baseUrl}/items'),
    headers: _headers,
  );
  
  if (response.statusCode == 200) {
    final data = jsonDecode(response.body);
    if (data['success']) {
      return data['data'];
    }
  }
  
  throw Exception('Failed to load items');
}
```

### Get Tables Function
```dart
Future<List<dynamic>> getTables() async {
  final response = await http.get(
    Uri.parse('${ApiService.baseUrl}/tables'),
    headers: _headers,
  );
  
  if (response.statusCode == 200) {
    final data = jsonDecode(response.body);
    if (data['success']) {
      return data['data'];
    }
  }
  
  throw Exception('Failed to load tables');
}
```

### Get Single Table Function
```dart
Future<Map<String, dynamic>> getTable(int tableId) async {
  final response = await http.get(
    Uri.parse('${ApiService.baseUrl}/tables/$tableId'),
    headers: _headers,
  );
  
  if (response.statusCode == 200) {
    final data = jsonDecode(response.body);
    if (data['success']) {
      return data['data'];
    }
  }
  
  throw Exception('Failed to load table');
}
```

### Branch Selection Function
```dart
Future<Map<String, dynamic>> selectBranch(int branchId) async {
  final response = await http.post(
    Uri.parse('${ApiService.baseUrl}/waiter/select-branch'),
    headers: _headers,
    body: jsonEncode({
      'branch_id': branchId,
    }),
  );
  
  if (response.statusCode == 200) {
    final data = jsonDecode(response.body);
    if (data['success']) {
      return data['data'];
    }
  }
  
  throw Exception('Branch selection failed');
}
```

### Get Complete Profile Function
```dart
Future<Map<String, dynamic>> getProfile() async {
  final response = await http.get(
    Uri.parse('${ApiService.baseUrl}/waiter/profile'),
    headers: _headers,
  );
  
  if (response.statusCode == 200) {
    final data = jsonDecode(response.body);
    if (data['success']) {
      return data['data'];
    }
  }
  
  throw Exception('Failed to load profile');
}
```

### Update Profile Function
```dart
Future<Map<String, dynamic>> updateProfile({
  String? name,
  String? email,
}) async {
  Map<String, dynamic> body = {};
  
  if (name != null) body['name'] = name;
  if (email != null) body['email'] = email;
  
  final response = await http.put(
    Uri.parse('${ApiService.baseUrl}/waiter/profile'),
    headers: _headers,
    body: jsonEncode(body),
  );
  
  if (response.statusCode == 200) {
    final data = jsonDecode(response.body);
    if (data['success']) {
      return data['data'];
    }
  }
  
  throw Exception('Failed to update profile');
}
```

## Data Models

### User Model
```dart
class User {
  final int id;
  final String name;
  final String email;
  
  User({required this.id, required this.name, required this.email});
  
  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'],
      name: json['name'],
      email: json['email'],
    );
  }
}
```

### Item Model
```dart
class Item {
  final int id;
  final String name;
  final int categoryId;
  final String type;
  final bool isAvailable;
  final List<ItemVariant> variants;
  final List<ItemAddon> addons;
  
  Item({
    required this.id,
    required this.name,
    required this.categoryId,
    required this.type,
    required this.isAvailable,
    required this.variants,
    required this.addons,
  });
  
  factory Item.fromJson(Map<String, dynamic> json) {
    return Item(
      id: json['id'],
      name: json['name'],
      categoryId: json['category_id'],
      type: json['type'],
      isAvailable: json['is_available'],
      variants: (json['variants'] as List)
          .map((v) => ItemVariant.fromJson(v))
          .toList(),
      addons: (json['addons'] as List)
          .map((a) => ItemAddon.fromJson(a))
          .toList(),
    );
  }
}
```

### Table Model
```dart
class Table {
  final int id;
  final String name;
  final int branchId;
  final int tablecategoryId;
  final String status;
  final String statusLabel;
  final String statusClass;
  final Map<String, dynamic>? lastOrder;
  
  Table({
    required this.id,
    required this.name,
    required this.branchId,
    required this.tablecategoryId,
    required this.status,
    required this.statusLabel,
    required this.statusClass,
    this.lastOrder,
  });
  
  factory Table.fromJson(Map<String, dynamic> json) {
    return Table(
      id: json['id'],
      name: json['name'],
      branchId: json['branch_id'],
      tablecategoryId: json['tablecategory_id'],
      status: json['status'],
      statusLabel: json['status_label'],
      statusClass: json['status_class'],
      lastOrder: json['last_order'],
    );
  }
}

class TableCategory {
  final int id;
  final String name;
  final int branchId;
  final List<Table> tables;
  
  TableCategory({
    required this.id,
    required this.name,
    required this.branchId,
    required this.tables,
  });
  
  factory TableCategory.fromJson(Map<String, dynamic> json) {
    return TableCategory(
      id: json['id'],
      name: json['name'],
      branchId: json['branch_id'],
      tables: (json['tables'] as List)
          .map((t) => Table.fromJson(t))
          .toList(),
    );
  }
}
```

### Profile Model
```dart
class Profile {
  final User user;
  final Branch? currentBranch;
  final List<Branch> branches;
  final int totalBranches;
  final bool hasMultipleBranches;
  final bool branchSelectionRequired;
  
  Profile({
    required this.user,
    this.currentBranch,
    required this.branches,
    required this.totalBranches,
    required this.hasMultipleBranches,
    required this.branchSelectionRequired,
  });
  
  factory Profile.fromJson(Map<String, dynamic> json) {
    return Profile(
      user: User.fromJson(json['user']),
      currentBranch: json['current_branch'] != null 
          ? Branch.fromJson(json['current_branch']) 
          : null,
      branches: (json['branches'] as List)
          .map((b) => Branch.fromJson(b))
          .toList(),
      totalBranches: json['total_branches'],
      hasMultipleBranches: json['has_multiple_branches'],
      branchSelectionRequired: json['branch_selection_required'],
    );
  }
}

class Branch {
  final int id;
  final String name;
  final String address;
  final String phone;
  final String email;
  final bool isCurrent;
  final DateTime createdAt;
  final DateTime updatedAt;
  
  Branch({
    required this.id,
    required this.name,
    required this.address,
    required this.phone,
    required this.email,
    required this.isCurrent,
    required this.createdAt,
    required this.updatedAt,
  });
  
  factory Branch.fromJson(Map<String, dynamic> json) {
    return Branch(
      id: json['id'],
      name: json['name'],
      address: json['address'] ?? '',
      phone: json['phone'] ?? '',
      email: json['email'] ?? '',
      isCurrent: json['is_current'] ?? false,
      createdAt: DateTime.parse(json['created_at']),
      updatedAt: DateTime.parse(json['updated_at']),
    );
  }
}
```

## Notes for AI Integration

1. **Authentication Flow**: Always login first, then select branch if needed, then make API calls
2. **Error Handling**: Check `success` field in response before using data
3. **Branch Filtering**: All data is automatically filtered by selected branch
4. **Token Management**: Store token securely and include in all protected requests
5. **Response Structure**: All successful responses follow the pattern: `{success: true, message: string, data: any}`
6. **Item Types**: Valid item types are: `size`, `piece`, `weight`, `flavour`, `combo`, `half`
7. **Relationships**: Items include variants and addons, tables include category info, categories include items

## Testing Endpoints

You can test these endpoints using tools like Postman or curl:

```bash
# Login
curl -X POST https://tabletray.ansdesk.com/api/waiter/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@gmail.com","password":"123456"}'

# Get tables with status (replace TOKEN with actual token)
curl -X GET https://tabletray.ansdesk.com/api/tables \
  -H "Authorization: Bearer TOKEN" \
  -H "Accept: application/json"

# Get single table with status (replace TOKEN and TABLE_ID)
curl -X GET https://tabletray.ansdesk.com/api/tables/TABLE_ID \
  -H "Authorization: Bearer TOKEN" \
  -H "Accept: application/json"

# Get complete profile (replace TOKEN with actual token)
curl -X GET https://tabletray.ansdesk.com/api/waiter/profile \
  -H "Authorization: Bearer TOKEN" \
  -H "Accept: application/json"

# Update profile (replace TOKEN with actual token)
curl -X PUT https://tabletray.ansdesk.com/api/waiter/profile \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"New Name","email":"newemail@gmail.com"}'
```

This documentation provides everything needed for Flutter integration and can be shared with AI assistants for future API development.
