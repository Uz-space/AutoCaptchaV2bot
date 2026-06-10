import asyncio
import logging
from aiogram import Bot, Dispatcher, F
from aiogram.types import Message, CallbackQuery, InlineKeyboardMarkup, InlineKeyboardButton
from aiogram.filters import CommandStart

logging.basicConfig(level=logging.INFO)

BOT_TOKEN = "YOUR_BOT_TOKEN_HERE"

# ─── Kran konfiguratsiyasi ───────────────────────────────────────────────────
CRANES = [
    {"name": "PolPick",  "emoji": "🪙",  "status": "⚠️", "active": False, "multiplier": None,  "claims": "0/∞"},
    {"name": "BnbPick",  "emoji": "🟡",  "status": "⚠️", "active": False, "multiplier": None,  "claims": "0/∞"},
    {"name": "DogePick", "emoji": "🐕",  "status": "⚠️", "active": False, "multiplier": None,  "claims": "0/∞"},
    {"name": "SolPick",  "emoji": "☀️",  "status": "⚠️", "active": False, "multiplier": None,  "claims": "0/∞"},
    {"name": "SuiPick",  "emoji": "💧",  "status": "⚠️", "active": False, "multiplier": None,  "claims": "0/∞"},
    {"name": "LitePick", "emoji": "🌕",  "status": "⚠️", "active": False, "multiplier": None,  "claims": "0/∞"},
    {"name": "TronPick", "emoji": "🔴",  "status": "⚠️", "active": False, "multiplier": None,  "claims": "0/∞"},
    {"name": "UsdPick",  "emoji": "💵",  "status": "⚠️", "active": False, "multiplier": None,  "claims": "0/∞"},
    {"name": "TonPick",  "emoji": "💎",  "status": "⚠️", "active": False, "multiplier": None,  "claims": "0/∞"},
    {"name": "BchPick",  "emoji": "🟤",  "status": "⚠️", "active": False, "multiplier": None,  "claims": "0/∞"},
]

# ─── Matn generatsiyasi ──────────────────────────────────────────────────────
def build_message_text() -> str:
    lines = []
    for c in CRANES:
        status = "✅" if c["active"] else "⚠️"
        if c["active"] and c["multiplier"]:
            line = f"{c['emoji']} {c['name']} {status} [∞] | {c['multiplier']} ({c['claims']})"
        else:
            line = f"{c['emoji']} {c['name']} {status} [∞] | ▪️ ({c['claims']})"
        lines.append(line)

    text = "\n".join(lines)
    text += "\n\n"
    text += "🔑 API: ✅ (sctg.xyz)\n"
    text += "🆓 Trial | ∞ accounts | 14 claims\n\n"
    text += "📡 LIVE LOG\n"
    text += "─" * 32 + "\n"
    text += "🌕 LitePick\n"
    text += "#8 | 66 | +0.00003 LTC! ⏳ 45m"
    return text

# ─── Inline klaviatura ───────────────────────────────────────────────────────
def build_keyboard() -> InlineKeyboardMarkup:
    buttons = []

    # Kran tugmalari — 2 tadan qator
    row = []
    for i, c in enumerate(CRANES):
        icon = "🟢" if c["active"] else "⚠️"
        btn = InlineKeyboardButton(
            text=f"{icon} {c['name']}",
            callback_data=f"crane_{c['name']}"
        )
        row.append(btn)
        if len(row) == 2:
            buttons.append(row)
            row = []
    if row:
        buttons.append(row)

    # Proxies — to'liq kenglik
    buttons.append([
        InlineKeyboardButton(text="🌐 Proxies", callback_data="proxies")
    ])

    # Tizim tugmalari — har biri alohida qatorda
    buttons.append([InlineKeyboardButton(text="📊 Stats & Balance", callback_data="stats")])
    buttons.append([InlineKeyboardButton(text="💳 Subscription",    callback_data="subscription")])
    buttons.append([InlineKeyboardButton(text="🎁 Invite Friend",   callback_data="invite")])

    # Settings + Refresh — yonma-yon
    buttons.append([
        InlineKeyboardButton(text="⚙️ Settings", callback_data="settings"),
        InlineKeyboardButton(text="🔄",           callback_data="refresh"),
    ])

    return InlineKeyboardMarkup(inline_keyboard=buttons)

# ─── Bot va Dispatcher ───────────────────────────────────────────────────────
bot = Bot(token=BOT_TOKEN)
dp  = Dispatcher()

# ─── /start handleri ─────────────────────────────────────────────────────────
@dp.message(CommandStart())
async def cmd_start(message: Message):
    await message.answer(
        text=build_message_text(),
        reply_markup=build_keyboard(),
        parse_mode=None
    )

# ─── Refresh callback ────────────────────────────────────────────────────────
@dp.callback_query(F.data == "refresh")
async def cb_refresh(call: CallbackQuery):
    await call.message.edit_text(
        text=build_message_text(),
        reply_markup=build_keyboard(),
        parse_mode=None
    )
    await call.answer("♻️ Yangilandi!")

# ─── Kran callback ───────────────────────────────────────────────────────────
@dp.callback_query(F.data.startswith("crane_"))
async def cb_crane(call: CallbackQuery):
    crane_name = call.data.replace("crane_", "")
    await call.answer(f"⚙️ {crane_name} sozlamalari (tez orada...)", show_alert=False)

# ─── Proxies callback ────────────────────────────────────────────────────────
@dp.callback_query(F.data == "proxies")
async def cb_proxies(call: CallbackQuery):
    await call.answer("🌐 Proxies bo'limi (tez orada...)", show_alert=False)

# ─── Stats callback ──────────────────────────────────────────────────────────
@dp.callback_query(F.data == "stats")
async def cb_stats(call: CallbackQuery):
    await call.answer("📊 Stats & Balance (tez orada...)", show_alert=False)

# ─── Subscription callback ───────────────────────────────────────────────────
@dp.callback_query(F.data == "subscription")
async def cb_subscription(call: CallbackQuery):
    await call.answer("💳 Subscription (tez orada...)", show_alert=False)

# ─── Invite callback ─────────────────────────────────────────────────────────
@dp.callback_query(F.data == "invite")
async def cb_invite(call: CallbackQuery):
    await call.answer("🎁 Invite Friend (tez orada...)", show_alert=False)

# ─── Settings callback ───────────────────────────────────────────────────────
@dp.callback_query(F.data == "settings")
async def cb_settings(call: CallbackQuery):
    await call.answer("⚙️ Settings (tez orada...)", show_alert=False)

# ─── Main ────────────────────────────────────────────────────────────────────
async def main():
    await dp.start_polling(bot)

if __name__ == "__main__":
    asyncio.run(main())
