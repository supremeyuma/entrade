import os
import re

# Configure folder path
folder = '.'  # current folder, or set to desired path

# Allowed video extensions
video_extensions = ['.mp4', '.mkv', '.avi', '.mov']

# Regex to detect episode identifiers like S01E01 or 1x01
episode_pattern = re.compile(r'(S\d{2}E\d{2})|(\d{1,2}x\d{2})', re.IGNORECASE)

# Gather all files
files = os.listdir(folder)

# Separate subtitles and video files
subtitles = [f for f in files if f.lower().endswith('.srt')]
videos = [f for f in files if os.path.splitext(f)[1].lower() in video_extensions]

def get_episode_code(name):
    match = episode_pattern.search(name)
    return match.group(0).lower() if match else None

# Create a mapping of episode -> subtitle name (without extension)
subtitle_map = {}
for sub in subtitles:
    code = get_episode_code(sub)
    if code:
        subtitle_map[code] = os.path.splitext(sub)[0]

# Match and rename video files
for video in videos:
    code = get_episode_code(video)
    if code and code in subtitle_map:
        video_ext = os.path.splitext(video)[1]
        new_name = f"{subtitle_map[code]}{video_ext}"
        old_path = os.path.join(folder, video)
        new_path = os.path.join(folder, new_name)

        if video != new_name:
            print(f"Renaming: {video} -> {new_name}")
            os.rename(old_path, new_path)

print("Renaming complete.")

