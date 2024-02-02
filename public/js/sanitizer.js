function sanitizeHTML(text) {
  return text.replace(/</g, "&lt;").replace(/>/g, "&gt;");
}