# Eymont Backend

Eymont is an adaptive AI-powered English learning platform designed to understand how each student learns.

It combines neuroscience-based learning, adaptive content delivery, error intelligence, spaced repetition and artificial intelligence.

## Vision

Eymont is not just an English exercise app.

Eymont learns how the user learns.

## Tech Stack

- Laravel 13
- Filament
- MongoDB
- MySQL
- Redis
- Laravel Sanctum
- Swagger / OpenAPI
- Docker
- Kotlin Android app

## Architecture

Eymont follows:

- Domain-Driven Design
- Hexagonal Architecture
- Modular Monolith
- API First
- AI First

## Core Concepts

### Content Block Architecture

Lessons are built from flexible blocks:

- reading
- grammar_pattern
- example
- exercise
- feedback
- review
- audio
- image
- micro_lesson

### Adaptive Learning Engine

The backend decides what to show next based on:

- correct and incorrect answers
- error type
- response time
- difficulty
- user history
- spaced repetition
- user level

### Error Intelligence

Eymont detects recurring learning patterns such as:

- missing auxiliary verbs
- incorrect DO / DOES usage
- wrong subject-verb order
- WH-question confusion
- vocabulary errors
- comprehension errors

### Neuro Tags

Content can be tagged by cognitive function:

- memory
- attention
- comprehension
- production
- recognition
- transfer
- repetition
- cognitive load

## Initial API

- GET /api/modules
- GET /api/modules/{id}
- GET /api/lessons/{id}
- POST /api/exercises/{id}/answer
- GET /api/users/me/progress

## Roadmap

See GitHub milestones for the public development roadmap.
