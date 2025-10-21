-- PT Aisin Indonesia - Recruitment System
-- PostgreSQL Schema Reference
-- Generated: 2025-10-21

-- ========================================
-- QUICK REFERENCE QUERIES
-- ========================================

-- List all tables
SELECT 
    schemaname,
    tablename,
    pg_size_pretty(pg_total_relation_size(schemaname||'.'||tablename)) AS size
FROM pg_tables
WHERE schemaname = 'public'
ORDER BY tablename;

-- View table structure
-- Usage: Replace 'table_name' with actual table name
-- \d+ table_name

-- Count records in all tables
SELECT 
    schemaname,
    tablename,
    (xpath('/row/cnt/text()', xml_count))[1]::text::int as row_count
FROM (
    SELECT 
        schemaname, 
        tablename, 
        query_to_xml(format('SELECT COUNT(*) AS cnt FROM %I.%I', schemaname, tablename), false, true, '') AS xml_count
    FROM pg_tables
    WHERE schemaname = 'public'
) t
ORDER BY row_count DESC;

-- ========================================
-- SECTION A: IDENTITY QUERIES
-- ========================================

-- Get complete applicant profile
SELECT 
    u.id,
    u.name,
    u.email,
    ai.full_name,
    ai.national_id_number,
    ai.phone_number,
    ai.gender,
    ai.birth_date,
    ai.religion
FROM users u
LEFT JOIN applicant_identities ai ON u.id = ai.user_id
WHERE u.id = 1; -- Replace with actual user_id

-- ========================================
-- SECTION B: EDUCATION QUERIES
-- ========================================

-- Get all education history for a user
SELECT 
    'Formal' as type,
    fe.level,
    fe.school_name,
    fe.major,
    fe.graduation_year
FROM formal_educations fe
WHERE fe.user_id = 1
UNION ALL
SELECT 
    'Non-Formal' as type,
    NULL as level,
    nfe.course_name,
    NULL as major,
    EXTRACT(YEAR FROM nfe.period_end)::integer
FROM non_formal_educations nfe
WHERE nfe.user_id = 1
ORDER BY graduation_year DESC;

-- Get language skills
SELECT 
    language_name,
    writing_skill,
    reading_skill,
    grammar_skill
FROM language_skills
WHERE user_id = 1;

-- ========================================
-- SECTION C: FAMILY QUERIES
-- ========================================

-- Get marital status and family info
SELECT 
    ms.status_actual,
    ms.status_date,
    COUNT(DISTINCT sc.id) FILTER (WHERE sc.relation_type = 'spouse') as spouse_count,
    COUNT(DISTINCT sc.id) FILTER (WHERE sc.relation_type LIKE 'child%') as children_count
FROM marital_statuses ms
LEFT JOIN spouses_and_children sc ON ms.user_id = sc.user_id
WHERE ms.user_id = 1
GROUP BY ms.status_actual, ms.status_date;

-- Get family tree
SELECT 
    relation_type,
    name,
    gender,
    birth_date,
    education,
    occupation
FROM family_members
WHERE user_id = 1
ORDER BY 
    CASE 
        WHEN relation_type = 'father' THEN 1
        WHEN relation_type = 'mother' THEN 2
        ELSE 3
    END,
    relation_type;

-- ========================================
-- JOBS & APPLICATIONS QUERIES
-- ========================================

-- Get all open jobs
SELECT 
    id,
    code,
    title,
    department,
    location,
    employment_type,
    posted_at,
    closing_at
FROM jobs
WHERE status = 'open'
    AND closing_at > NOW()
ORDER BY posted_at DESC;

-- Get application with full details
SELECT 
    a.id,
    a.application_number,
    j.title as job_title,
    u.name as applicant_name,
    u.email as applicant_email,
    a.current_stage,
    a.applied_at,
    a.source
FROM applications a
JOIN jobs j ON a.job_id = j.id
JOIN users u ON a.user_id = u.id
WHERE a.id = 1; -- Replace with actual application_id

-- Get application stage history
SELECT 
    ash.from_stage,
    ash.to_stage,
    u.name as changed_by,
    ash.changed_at,
    ash.notes
FROM application_stage_histories ash
LEFT JOIN users u ON ash.changed_by = u.id
WHERE ash.application_id = 1
ORDER BY ash.changed_at DESC;

-- ========================================
-- RECRUITMENT PROCESS QUERIES
-- ========================================

-- Get recruitment pipeline status for an application
SELECT 
    a.application_number,
    a.current_stage,
    
    -- Administrative
    ads.status as admin_status,
    ads.reviewed_at as admin_reviewed_at,
    
    -- Psychotest
    COUNT(DISTINCT p.id) as psychotest_count,
    MAX(p.status) as latest_psychotest_status,
    
    -- Interview
    COUNT(DISTINCT i.id) as interview_count,
    COUNT(DISTINCT i.id) FILTER (WHERE i.result = 'passed') as interviews_passed,
    
    -- Background Check
    COUNT(DISTINCT bc.id) as bgcheck_count,
    COUNT(DISTINCT bc.id) FILTER (WHERE bc.result = 'passed') as bgcheck_passed,
    
    -- Medical Checkup
    mc.status as mcu_status,
    mc.result as mcu_result,
    
    -- Hiring Approval
    ha.status as hiring_status,
    ha.approved_at
    
FROM applications a
LEFT JOIN administrative_selections ads ON a.id = ads.application_id
LEFT JOIN psychotests p ON a.id = p.application_id
LEFT JOIN interviews i ON a.id = i.application_id
LEFT JOIN background_checks bc ON a.id = bc.application_id
LEFT JOIN medical_checkups mc ON a.id = mc.application_id
LEFT JOIN hiring_approvals ha ON a.id = ha.application_id
WHERE a.id = 1
GROUP BY 
    a.application_number, a.current_stage,
    ads.status, ads.reviewed_at,
    mc.status, mc.result,
    ha.status, ha.approved_at;

-- Get all applications by stage
SELECT 
    current_stage,
    COUNT(*) as count
FROM applications
GROUP BY current_stage
ORDER BY 
    CASE current_stage
        WHEN 'applied' THEN 1
        WHEN 'administrative' THEN 2
        WHEN 'psychotest' THEN 3
        WHEN 'interview' THEN 4
        WHEN 'background_check' THEN 5
        WHEN 'medical_checkup' THEN 6
        WHEN 'hiring_approval' THEN 7
        WHEN 'hired' THEN 8
        WHEN 'rejected' THEN 9
        ELSE 10
    END;

-- ========================================
-- ANALYTICS QUERIES
-- ========================================

-- Application funnel analysis
WITH funnel AS (
    SELECT 
        COUNT(*) FILTER (WHERE current_stage = 'applied') as applied,
        COUNT(*) FILTER (WHERE current_stage IN ('administrative', 'psychotest', 'interview', 'background_check', 'medical_checkup', 'hiring_approval', 'hired')) as passed_admin,
        COUNT(*) FILTER (WHERE current_stage IN ('psychotest', 'interview', 'background_check', 'medical_checkup', 'hiring_approval', 'hired')) as passed_psycho,
        COUNT(*) FILTER (WHERE current_stage IN ('interview', 'background_check', 'medical_checkup', 'hiring_approval', 'hired')) as passed_interview,
        COUNT(*) FILTER (WHERE current_stage IN ('background_check', 'medical_checkup', 'hiring_approval', 'hired')) as passed_bgc,
        COUNT(*) FILTER (WHERE current_stage IN ('medical_checkup', 'hiring_approval', 'hired')) as passed_mcu,
        COUNT(*) FILTER (WHERE current_stage = 'hired') as hired,
        COUNT(*) FILTER (WHERE current_stage = 'rejected') as rejected
    FROM applications
)
SELECT 
    'Applied' as stage, applied as count, 100.0 as percentage FROM funnel
UNION ALL
SELECT 'Passed Admin', passed_admin, ROUND(100.0 * passed_admin / NULLIF(applied, 0), 2) FROM funnel
UNION ALL
SELECT 'Passed Psychotest', passed_psycho, ROUND(100.0 * passed_psycho / NULLIF(applied, 0), 2) FROM funnel
UNION ALL
SELECT 'Passed Interview', passed_interview, ROUND(100.0 * passed_interview / NULLIF(applied, 0), 2) FROM funnel
UNION ALL
SELECT 'Passed BGC', passed_bgc, ROUND(100.0 * passed_bgc / NULLIF(applied, 0), 2) FROM funnel
UNION ALL
SELECT 'Passed MCU', passed_mcu, ROUND(100.0 * passed_mcu / NULLIF(applied, 0), 2) FROM funnel
UNION ALL
SELECT 'Hired', hired, ROUND(100.0 * hired / NULLIF(applied, 0), 2) FROM funnel
UNION ALL
SELECT 'Rejected', rejected, ROUND(100.0 * rejected / NULLIF(applied, 0), 2) FROM funnel;

-- Average time in each stage
SELECT 
    from_stage,
    to_stage,
    COUNT(*) as transitions,
    AVG(EXTRACT(EPOCH FROM (changed_at - LAG(changed_at) OVER (PARTITION BY application_id ORDER BY changed_at))) / 86400)::numeric(10,2) as avg_days
FROM application_stage_histories
GROUP BY from_stage, to_stage
ORDER BY transitions DESC;

-- Top skills among applicants
SELECT 
    skill_name,
    proficiency_level,
    COUNT(*) as count
FROM applicant_skills
GROUP BY skill_name, proficiency_level
ORDER BY count DESC
LIMIT 20;

-- Department preferences distribution
SELECT 
    department_name,
    priority_order,
    COUNT(*) as count
FROM department_preferences
GROUP BY department_name, priority_order
ORDER BY department_name, priority_order;

-- ========================================
-- ACTIVITY LOG QUERIES
-- ========================================

-- Recent activity log
SELECT 
    al.description,
    al.subject_type,
    al.subject_id,
    al.event,
    al.created_at,
    al.properties
FROM activity_log al
ORDER BY al.created_at DESC
LIMIT 50;

-- User activity summary
SELECT 
    causer_id,
    COUNT(*) as activity_count,
    MAX(created_at) as last_activity
FROM activity_log
WHERE causer_type = 'App\Models\User'
GROUP BY causer_id
ORDER BY activity_count DESC;

-- ========================================
-- USEFUL MAINTENANCE QUERIES
-- ========================================

-- Find orphaned records (users without identity)
SELECT 
    u.id,
    u.name,
    u.email,
    u.created_at
FROM users u
LEFT JOIN applicant_identities ai ON u.id = ai.user_id
WHERE ai.id IS NULL;

-- Check data completeness for applicants
SELECT 
    u.id,
    u.name,
    CASE WHEN ai.id IS NOT NULL THEN '✓' ELSE '✗' END as has_identity,
    CASE WHEN ms.id IS NOT NULL THEN '✓' ELSE '✗' END as has_marital_status,
    CASE WHEN am.id IS NOT NULL THEN '✓' ELSE '✗' END as has_motivation,
    COUNT(DISTINCT fe.id) as formal_education_count,
    COUNT(DISTINCT we.id) as work_experience_count,
    COUNT(DISTINCT sk.id) as skills_count
FROM users u
LEFT JOIN applicant_identities ai ON u.id = ai.user_id
LEFT JOIN marital_statuses ms ON u.id = ms.user_id
LEFT JOIN applicant_motivations am ON u.id = am.user_id
LEFT JOIN formal_educations fe ON u.id = fe.user_id
LEFT JOIN work_experiences we ON u.id = we.user_id
LEFT JOIN applicant_skills sk ON u.id = sk.user_id
GROUP BY u.id, u.name, ai.id, ms.id, am.id
ORDER BY u.id;

-- Database size by table
SELECT 
    schemaname AS schema,
    tablename AS table,
    pg_size_pretty(pg_total_relation_size(schemaname||'.'||tablename)) AS total_size,
    pg_size_pretty(pg_relation_size(schemaname||'.'||tablename)) AS table_size,
    pg_size_pretty(pg_total_relation_size(schemaname||'.'||tablename) - pg_relation_size(schemaname||'.'||tablename)) AS indexes_size
FROM pg_tables
WHERE schemaname = 'public'
ORDER BY pg_total_relation_size(schemaname||'.'||tablename) DESC;
