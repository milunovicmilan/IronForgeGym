<?php
use OpenApi\Attributes as OA;

#[OA\Info(title: 'IronForge Gym API', version: '3.0.0', description: 'Milestone 3: services, CRUD routes and weather.')]
#[OA\Server(url: API_BASE_PATH, description: 'Current installation')]
#[OA\Schema(schema: 'Error', required: ['status', 'error'], properties: [new OA\Property(property: 'status', type: 'integer', example: 400), new OA\Property(property: 'error', type: 'string', example: 'The request is invalid.')])]
#[OA\Schema(schema: 'Message', required: ['message'], properties: [new OA\Property(property: 'message', type: 'string', example: 'Record deleted.')])]
#[OA\Schema(schema: 'Health', properties: [new OA\Property(property: 'app', type: 'string', example: 'IronForge Gym API'), new OA\Property(property: 'message', type: 'string', example: 'The backend is running.'), new OA\Property(property: 'docs', type: 'string', example: 'public/v1/docs/')])]
#[OA\Schema(schema: 'UserInput', type: 'object', additionalProperties: false, required: ['full_name', 'email', 'password'], properties: [
        new OA\Property(property: 'full_name', type: 'string', example: 'Demo Member'),
        new OA\Property(property: 'email', type: 'string', example: 'member@example.test', format: 'email'),
        new OA\Property(property: 'password', type: 'string', example: 'DemoPass123', writeOnly: true, minLength: 8, maxLength: 72),
        new OA\Property(property: 'role', type: 'string', example: 'user', enum: ['user', 'admin']),
        new OA\Property(property: 'join_date', type: 'string', example: '2026-11-20', format: 'date')
]) ]
#[OA\Schema(schema: 'UserUpdate', type: 'object', additionalProperties: false, properties: [
        new OA\Property(property: 'full_name', type: 'string', example: 'Demo Member'),
        new OA\Property(property: 'email', type: 'string', example: 'member@example.test', format: 'email'),
        new OA\Property(property: 'password', type: 'string', example: 'DemoPass123', writeOnly: true, minLength: 8, maxLength: 72),
        new OA\Property(property: 'role', type: 'string', example: 'user', enum: ['user', 'admin']),
        new OA\Property(property: 'join_date', type: 'string', example: '2026-11-20', format: 'date')
]) ]
#[OA\Schema(schema: 'User', type: 'object', required: ['user_id'], properties: [
        new OA\Property(property: 'user_id', type: 'integer', example: 1),
        new OA\Property(property: 'full_name', type: 'string', example: 'Demo Member'),
        new OA\Property(property: 'email', type: 'string', example: 'member@example.test', format: 'email', nullable: true),
        new OA\Property(property: 'role', type: 'string', example: 'user', enum: ['user', 'admin']),
        new OA\Property(property: 'join_date', type: 'string', example: '2026-11-20', format: 'date', nullable: true)
]) ]
#[OA\Schema(schema: 'CategoryInput', type: 'object', additionalProperties: false, required: ['name'], properties: [
        new OA\Property(property: 'name', type: 'string', example: 'Mobility'),
        new OA\Property(property: 'description', type: 'string', example: 'Mobility and recovery classes', nullable: true)
]) ]
#[OA\Schema(schema: 'CategoryUpdate', type: 'object', additionalProperties: false, properties: [
        new OA\Property(property: 'name', type: 'string', example: 'Mobility'),
        new OA\Property(property: 'description', type: 'string', example: 'Mobility and recovery classes', nullable: true)
]) ]
#[OA\Schema(schema: 'Category', type: 'object', required: ['category_id'], properties: [
        new OA\Property(property: 'category_id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Mobility'),
        new OA\Property(property: 'description', type: 'string', example: 'Mobility and recovery classes', nullable: true)
]) ]
#[OA\Schema(schema: 'TrainerInput', type: 'object', additionalProperties: false, required: ['full_name'], properties: [
        new OA\Property(property: 'full_name', type: 'string', example: 'Demo Trainer'),
        new OA\Property(property: 'specialization', type: 'string', example: 'Strength', nullable: true),
        new OA\Property(property: 'phone', type: 'string', example: '061123456', nullable: true),
        new OA\Property(property: 'email', type: 'string', example: 'trainer@example.test', format: 'email'),
        new OA\Property(property: 'experience_years', type: 'integer', example: 5)
]) ]
#[OA\Schema(schema: 'TrainerUpdate', type: 'object', additionalProperties: false, properties: [
        new OA\Property(property: 'full_name', type: 'string', example: 'Demo Trainer'),
        new OA\Property(property: 'specialization', type: 'string', example: 'Strength', nullable: true),
        new OA\Property(property: 'phone', type: 'string', example: '061123456', nullable: true),
        new OA\Property(property: 'email', type: 'string', example: 'trainer@example.test', format: 'email'),
        new OA\Property(property: 'experience_years', type: 'integer', example: 5)
]) ]
#[OA\Schema(schema: 'Trainer', type: 'object', required: ['trainer_id'], properties: [
        new OA\Property(property: 'trainer_id', type: 'integer', example: 1),
        new OA\Property(property: 'full_name', type: 'string', example: 'Demo Trainer'),
        new OA\Property(property: 'specialization', type: 'string', example: 'Strength', nullable: true),
        new OA\Property(property: 'phone', type: 'string', example: '061123456', nullable: true),
        new OA\Property(property: 'email', type: 'string', example: 'trainer@example.test', format: 'email', nullable: true),
        new OA\Property(property: 'experience_years', type: 'integer', example: 5, nullable: true)
]) ]
#[OA\Schema(schema: 'ClassInput', type: 'object', additionalProperties: false, required: ['title', 'category_id', 'trainer_id', 'schedule_time', 'capacity'], properties: [
        new OA\Property(property: 'title', type: 'string', example: 'Strength Basics'),
        new OA\Property(property: 'description', type: 'string', example: 'Beginner session', nullable: true),
        new OA\Property(property: 'category_id', type: 'integer', example: 1),
        new OA\Property(property: 'trainer_id', type: 'integer', example: 1),
        new OA\Property(property: 'schedule_time', type: 'string', example: '2027-01-20 18:00:00', description: 'UTC SQL datetime (YYYY-MM-DD HH:MM:SS) or HTML datetime-local'),
        new OA\Property(property: 'capacity', type: 'integer', example: 20)
]) ]
#[OA\Schema(schema: 'ClassUpdate', type: 'object', additionalProperties: false, properties: [
        new OA\Property(property: 'title', type: 'string', example: 'Strength Basics'),
        new OA\Property(property: 'description', type: 'string', example: 'Beginner session', nullable: true),
        new OA\Property(property: 'category_id', type: 'integer', example: 1),
        new OA\Property(property: 'trainer_id', type: 'integer', example: 1),
        new OA\Property(property: 'schedule_time', type: 'string', example: '2027-01-20 18:00:00', description: 'UTC SQL datetime (YYYY-MM-DD HH:MM:SS) or HTML datetime-local'),
        new OA\Property(property: 'capacity', type: 'integer', example: 20)
]) ]
#[OA\Schema(schema: 'Class', type: 'object', required: ['class_id'], properties: [
        new OA\Property(property: 'class_id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: 'Strength Basics'),
        new OA\Property(property: 'description', type: 'string', example: 'Beginner session', nullable: true),
        new OA\Property(property: 'category_id', type: 'integer', example: 1, nullable: true),
        new OA\Property(property: 'trainer_id', type: 'integer', example: 1, nullable: true),
        new OA\Property(property: 'schedule_time', type: 'string', example: '2027-01-20 18:00:00', description: 'UTC SQL datetime (YYYY-MM-DD HH:MM:SS) or HTML datetime-local', nullable: true),
        new OA\Property(property: 'capacity', type: 'integer', example: 20, nullable: true)
]) ]
#[OA\Schema(schema: 'MembershipInput', type: 'object', additionalProperties: false, required: ['name', 'price', 'duration_months'], properties: [
        new OA\Property(property: 'name', type: 'string', example: 'Monthly'),
        new OA\Property(property: 'description', type: 'string', example: 'One month access', nullable: true),
        new OA\Property(property: 'price', type: 'number', example: 50.0),
        new OA\Property(property: 'duration_months', type: 'integer', example: 1)
]) ]
#[OA\Schema(schema: 'MembershipUpdate', type: 'object', additionalProperties: false, properties: [
        new OA\Property(property: 'name', type: 'string', example: 'Monthly'),
        new OA\Property(property: 'description', type: 'string', example: 'One month access', nullable: true),
        new OA\Property(property: 'price', type: 'number', example: 50.0),
        new OA\Property(property: 'duration_months', type: 'integer', example: 1)
]) ]
#[OA\Schema(schema: 'Membership', type: 'object', required: ['membership_id'], properties: [
        new OA\Property(property: 'membership_id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Monthly'),
        new OA\Property(property: 'description', type: 'string', example: 'One month access', nullable: true),
        new OA\Property(property: 'price', type: 'string', example: '50.00', description: 'MySQL DECIMAL is serialized as a string'),
        new OA\Property(property: 'duration_months', type: 'integer', example: 1)
]) ]
#[OA\Schema(schema: 'BookingInput', type: 'object', additionalProperties: false, required: ['user_id', 'class_id'], properties: [
        new OA\Property(property: 'user_id', type: 'integer', example: 1),
        new OA\Property(property: 'class_id', type: 'integer', example: 1),
        new OA\Property(property: 'status', type: 'string', example: 'booked', enum: ['booked', 'cancelled'])
]) ]
#[OA\Schema(schema: 'BookingUpdate', type: 'object', additionalProperties: false, properties: [
        new OA\Property(property: 'user_id', type: 'integer', example: 1),
        new OA\Property(property: 'class_id', type: 'integer', example: 1),
        new OA\Property(property: 'status', type: 'string', example: 'booked', enum: ['booked', 'cancelled'])
]) ]
#[OA\Schema(schema: 'Booking', type: 'object', required: ['booking_id'], properties: [
        new OA\Property(property: 'booking_id', type: 'integer', example: 1),
        new OA\Property(property: 'user_id', type: 'integer', example: 1),
        new OA\Property(property: 'class_id', type: 'integer', example: 1),
        new OA\Property(property: 'status', type: 'string', example: 'booked', enum: ['booked', 'cancelled'], nullable: true),
        new OA\Property(property: 'booking_date', type: 'string', example: '2026-11-20 12:00:00')
]) ]
#[OA\Schema(schema: 'UserMembershipInput', type: 'object', additionalProperties: false, required: ['user_id', 'membership_id', 'start_date'], properties: [
        new OA\Property(property: 'user_id', type: 'integer', example: 1),
        new OA\Property(property: 'membership_id', type: 'integer', example: 1),
        new OA\Property(property: 'start_date', type: 'string', example: '2027-01-01', format: 'date'),
        new OA\Property(property: 'end_date', type: 'string', example: '2027-02-01', format: 'date')
]) ]
#[OA\Schema(schema: 'UserMembershipUpdate', type: 'object', additionalProperties: false, properties: [
        new OA\Property(property: 'user_id', type: 'integer', example: 1),
        new OA\Property(property: 'membership_id', type: 'integer', example: 1),
        new OA\Property(property: 'start_date', type: 'string', example: '2027-01-01', format: 'date'),
        new OA\Property(property: 'end_date', type: 'string', example: '2027-02-01', format: 'date')
]) ]
#[OA\Schema(schema: 'UserMembership', type: 'object', required: ['user_membership_id'], properties: [
        new OA\Property(property: 'user_membership_id', type: 'integer', example: 1),
        new OA\Property(property: 'user_id', type: 'integer', example: 1),
        new OA\Property(property: 'membership_id', type: 'integer', example: 1),
        new OA\Property(property: 'start_date', type: 'string', example: '2027-01-01', format: 'date', nullable: true),
        new OA\Property(property: 'end_date', type: 'string', example: '2027-02-01', format: 'date', nullable: true)
]) ]
#[OA\Schema(schema: 'ClassDetails', allOf: [new OA\Schema(ref: '#/components/schemas/Class')], properties: [new OA\Property(property: 'trainer_name', type: 'string', nullable: true), new OA\Property(property: 'category_name', type: 'string', nullable: true)])]
#[OA\Schema(schema: 'AvailableClass', allOf: [new OA\Schema(ref: '#/components/schemas/Class')], properties: [new OA\Property(property: 'available_spots', type: 'integer', example: 3)])]
#[OA\Schema(schema: 'UserBooking', allOf: [new OA\Schema(ref: '#/components/schemas/Booking')], properties: [new OA\Property(property: 'class_title', type: 'string'), new OA\Property(property: 'schedule_time', type: 'string')])]
#[OA\Schema(schema: 'ClassBooking', allOf: [new OA\Schema(ref: '#/components/schemas/Booking')], properties: [new OA\Property(property: 'full_name', type: 'string'), new OA\Property(property: 'email', type: 'string')])]
#[OA\Schema(schema: 'UserPlan', allOf: [new OA\Schema(ref: '#/components/schemas/UserMembership')], properties: [new OA\Property(property: 'membership_name', type: 'string'), new OA\Property(property: 'price', type: 'string')])]
#[OA\Schema(schema: 'ActivePlan', allOf: [new OA\Schema(ref: '#/components/schemas/UserMembership')], properties: [new OA\Property(property: 'name', type: 'string'), new OA\Property(property: 'description', type: 'string', nullable: true), new OA\Property(property: 'price', type: 'string')])]
#[OA\Schema(schema: 'Weather', required: ['city','source','timezone','observed_at','temperature_c','wind_kmh','precipitation_mm','condition','advice'], properties: [new OA\Property(property: 'city', type: 'string', example: 'Sarajevo'), new OA\Property(property: 'source', type: 'string', example: 'Open-Meteo'), new OA\Property(property: 'timezone', type: 'string', example: 'UTC'), new OA\Property(property: 'observed_at', type: 'string', example: '2026-11-20T12:00'), new OA\Property(property: 'temperature_c', type: 'number', example: 12.3), new OA\Property(property: 'wind_kmh', type: 'number', example: 8.0), new OA\Property(property: 'precipitation_mm', type: 'number', example: 0), new OA\Property(property: 'condition', type: 'string', example: 'Clear'), new OA\Property(property: 'advice', type: 'string', example: 'Conditions may suit an outdoor warm-up before your gym session.')])]
class DocSetup {}
